<?php

class MVDB_MovieDatabase
{
    private MVDB_Loader $loader;

    public function __construct()
    {
        $this->load_dependencies();
        $this->set_locale();
        $this->register_mvdb_cpt();
    }

    private function load_dependencies(): void
    {
        require_once MVDB_PLUGIN . 'includes/class-movie-database-loader.php';
        require_once MVDB_PLUGIN . 'includes/class-movie-database-i18n.php';
        require_once MVDB_PLUGIN . 'includes/class-movie-database-cpt-creator.php';
        $this->loader = new MVDB_Loader();
    }

    private function set_locale(): void
    {
        $mvdb_i18n = new MVDB_i18n();
        $this->loader->add_action('plugins_loaded', $mvdb_i18n, 'mvdb_load_textdomain');
    }

    private function register_mvdb_cpt(): void
    {
        $mvdb_cpt_creator = new MVDB_CPT_Creator();
        $mvdb_cpt_creator->setName('film')->setPublic(true)->setLabels([
            'name'          => _x('Filmovi', 'All movies', 'movie-database'),
            'singular_name' => _x('Film', 'Movie', 'movie-database'),
            'add_new'       => _x('Dodaj novi film', 'Add new movie', 'movie-database'),
            'add_new_item'  => _x('Dodaj novi film', 'Add new movie', 'movie-database'),
            'edit_item'     => _x('Izmeni film', 'Edit movie', 'movie-database'),
            'new_item'      => _x('Novi film', 'New movie', 'movie-database'),
            'view_item'     => _x('Vidi film', 'View movie', 'movie-database'),
            'view_items'    => _x('Vidi filmove', 'View movies', 'movie-database'),
            'search_items'  => _x('Pretrazi filmove', 'Searh movies', 'movie-database'),
            'not_found'     => _x('Nije pronadjen nijedan film', 'No movies found', 'movie-database'),
            'all_items'     => _x('Svi filmovi', 'All movies', 'movie-database'),
        ]);
        $mvdb_cpt_creator->register_taxonomy('kategorije', 'Kategorija');
        $this->loader->add_action('init', $mvdb_cpt_creator, 'register');
        $this->loader->add_action('init', $mvdb_cpt_creator->taxonomy, 'register');
    }

    public function run(): void
    {
        $this->loader->run();
    }
}