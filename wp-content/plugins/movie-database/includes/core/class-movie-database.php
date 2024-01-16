<?php

class MVDB_MovieDatabase
{
    private MVDB_Loader $loader;

    public function __construct()
    {
        $this->load_dependencies();
        $this->create_table();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->register_mvdb_cpt();
        $this->create_mvdb_cpt_custom_fields();
        $this->register_movies_import_cron();
        $this->register_form();
    }

    private function load_dependencies(): void
    {
        require_once MVDB_PLUGIN . 'includes/core/class-movie-database-loader.php';
        require_once MVDB_PLUGIN . 'includes/core/class-movie-database-i18n.php';
        require_once MVDB_PLUGIN . 'admin/class-movie-database-admin.php';
        require_once MVDB_PLUGIN . 'public/class-movie-database-public.php';
        require_once MVDB_PLUGIN . 'includes/settings/class-movie-database-settings.php';
        require_once MVDB_PLUGIN . 'includes/repository/class-movie-database-movie-repository.php';
        require_once MVDB_PLUGIN . 'includes/repository/class-movie-database-genre-repository.php';
        require_once MVDB_PLUGIN . 'includes/cpt/class-movie-database-cpt-creator.php';
        require_once MVDB_PLUGIN . 'includes/cpt/class-movie-database-custom-field-creator.php';
        require_once MVDB_PLUGIN . 'includes/import/class-movie-database-import-movies.php';
        require_once MVDB_PLUGIN . 'includes/form/class-movie-database-form.php';
        require_once MVDB_PLUGIN . 'includes/ajax/class-movie-database-form-ajax.php';
        $this->loader = new MVDB_Loader();
    }

    private function create_table(): void
    {
        $mvdb_movie_repository = new MVDB_Movie_Repository();
        $mvdb_genre_repository = new MVDB_Genre_Repository();
        $mvdb_movie_repository->create_table();
        $mvdb_genre_repository->create_table();
    }

    private function set_locale(): void
    {
        $mvdb_i18n = new MVDB_i18n();
        $this->loader->add_action('plugins_loaded', $mvdb_i18n, 'mvdb_load_textdomain');
    }

    private function define_admin_hooks(): void
    {
        $mvdb_admin = new MVDB_Admin();
        $mvdb_settings = new MVDB_Settings();
        $this->loader->add_action('admin_enqueue_scripts', $mvdb_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $mvdb_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $mvdb_settings, 'register_mvdb_settings');
    }

    private function define_public_hooks(): void
    {
        $mvdb_public = new MVDB_Public();
        $this->loader->add_action('wp_enqueue_scripts', $mvdb_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $mvdb_public, 'enqueue_scripts');
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

    private function create_mvdb_cpt_custom_fields(): void
    {
        $mvdb_custom_field_creator = new MVDB_Custom_Field_Creator();
        $this->loader->add_action('add_meta_boxes', $mvdb_custom_field_creator, 'create');
        $this->loader->add_action('save_post_film', $mvdb_custom_field_creator, 'save_custom_fields');
    }

    private function register_movies_import_cron(): void
    {
        $mvdb_importer = new MVDB_Import_Movies();
        $this->loader->add_action('mvdb_import_movies_hook', $mvdb_importer, 'import');
        if (!wp_next_scheduled('mvdb_import_movies_hook')) {
            wp_schedule_event(strtotime('midnight'), 'daily', 'mvdb_import_movies_hook');
        }
    }

    private function register_form(): void
    {
        $mvdb_form = new MVDB_Form();
        $mvdb_form_ajax = new MVDB_Form_Ajax();
        $this->loader->add_action('init', $mvdb_form, 'register_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_mvdb_submit_form', $mvdb_form_ajax, 'submit');
        $this->loader->add_action('wp_ajax_mvdb_submit_form', $mvdb_form_ajax, 'submit');
    }

    public function run(): void
    {
        $this->loader->run();
    }
}