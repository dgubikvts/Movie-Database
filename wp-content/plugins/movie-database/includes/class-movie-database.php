<?php

class MVDB_Init
{
    private MVDB_Loader $loader;

    public function __construct()
    {
        $this->load_dependencies();
        $this->set_locale();
    }

    private function load_dependencies(): void
    {
        require_once MVDB_PLUGIN . 'includes/class-movie-database-loader.php';
        require_once MVDB_PLUGIN . 'includes/class-movie-database-i18n.php';
        $this->loader = new MVDB_Loader();
    }

    private function set_locale(): void
    {
        $mvdb_i18n = new MVDB_i18n();
        $this->loader->add_action('plugins_loaded', $mvdb_i18n, 'mvdb_load_textdomain');
    }

    public function run(): void
    {
        $this->loader->run();
    }
}