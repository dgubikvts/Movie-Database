<?php

require_once MVDB_PLUGIN . "includes/import/services/class-movie-database-movie-import-service.php";
require_once MVDB_PLUGIN . "includes/import/services/class-movie-database-genre-import-service.php";
require_once MVDB_PLUGIN . "includes/import/services/class-movie-database-image-import-service.php";
require_once MVDB_PLUGIN . "includes/import/services/class-movie-database-trailer-import-service.php";
require_once MVDB_PLUGIN . "includes/import/services/class-movie-database-cast-import-service.php";
require_once MVDB_PLUGIN . "includes/repository/class-movie-database-movie-repository.php";
require_once MVDB_PLUGIN . "includes/repository/class-movie-database-genre-repository.php";

class MVDB_Import_Movies
{
    private MVDB_Movie_Import_Service $movie_service;
    private MVDB_Genre_Import_Service $genre_service;
    private MVDB_Image_Import_Service $image_service;
    private MVDB_Trailer_Import_Service $trailer_service;
    private MVDB_Cast_Import_Service $cast_service;
    private MVDB_Movie_Repository $repository;
    private MVDB_Genre_Repository $genre_repository;

    public function __construct()
    {
        $this->movie_service = new MVDB_Movie_Import_Service();
        $this->genre_service = new MVDB_Genre_Import_Service();
        $this->image_service = new MVDB_Image_Import_Service();
        $this->trailer_service = new MVDB_Trailer_Import_Service();
        $this->cast_service = new MVDB_Cast_Import_Service();
        $this->repository = new MVDB_Movie_Repository();
        $this->genre_repository = new MVDB_Genre_Repository();
    }

    public function import(): void
    {
        $this->importGenres();
        $popular_movies = $this->movie_service->getData();
        foreach($popular_movies as $movie){
            $post_id = $this->createMovieIfNotExists($movie);
            $cast = $this->cast_service->prepareClientUri($movie['movie_id'])->getData();
            $gallery = $this->image_service->prepareClientUri($movie['movie_id'])->getData();
            $trailer = $this->trailer_service->prepareClientUri($movie['movie_id'])->getData();
            $this->addMovieFeaturedImage($post_id, $gallery);
            $this->addMovieCategories($post_id, $movie['genre']);
            $this->repository->save([
                'cast' => $cast,
                'gallery' => $gallery,
                'trailer' => $trailer,
                'post_id' => $post_id,
                'rating' => $movie['rating'],
                'release_date' => $movie['release_date'],
                'genre' => $movie['genre']
            ]);
        }
    }

    private function importGenres(): void
    {
        $genres = $this->genre_service->getData();
        foreach($genres as $genre){
            if(term_exists($genre['name'], 'kategorije')) continue;
            $term = wp_insert_term($genre['name'], 'kategorije');
            $this->genre_repository->save([
                'term_id' => $term['term_id'],
                'genre_id' => $genre['id']
            ]);
        }
    }

    private function createMovieIfNotExists(array $data): int
    {
        $posts = get_posts(['post_status' => 'any', 'post_type' => 'film', 'title' => $data['post_title'], 'fields' => 'ids']);
        if(isset($posts[0])) {
            wp_update_post([
                'ID' => $posts[0],
                'post_content' => $data['post_content']
            ]);
            return $posts[0];
        }
        return $this->createMovie($data);
    }

    private function createMovie(array $data): int
    {
        return wp_insert_post([
            'post_title'    => $data['post_title'],
            'post_content'  => $data['post_content'],
            'post_type'     => 'film',
            'post_status'   => 'publish'
        ]);
    }

    private function addMovieCategories(string $post_id, string $genres): void
    {
        $genres = unserialize($genres);
        foreach($genres as $genre){
            $term_id = $this->genre_repository->getFieldWhere('term_id', ['genre_id' => $genre]);
            if($term_id) $terms[] = (int) $term_id;
        }
        wp_set_post_terms($post_id, $terms ?? [], 'kategorije');
    }

    private function addMovieFeaturedImage(string $post_id, string $images): void
    {
        $images = unserialize($images);
        if(!$images || !count($images)) return;
        set_post_thumbnail($post_id, attachment_url_to_postid($images[0]));
    }
}