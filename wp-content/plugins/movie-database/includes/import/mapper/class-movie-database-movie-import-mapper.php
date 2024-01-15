<?php

require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-abstract-import-mapper.php';

class MVDB_Movie_Import_Mapper extends MVDB_Abstract_Import_Mapper
{
    protected array $fields = [
        'genre_ids' => 'genre',
        'id' => 'movie_id',
        'vote_average' => 'rating',
        'release_date' => 'release_date',
        'title' => 'post_title',
        'overview' => 'post_content'
    ];

    protected function prepareGenreIdsAttribute(mixed $value): string
    {
        return serialize($value);
    }
}