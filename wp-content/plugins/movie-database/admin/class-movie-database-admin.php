<?php

class MVDB_Admin
{
    public function enqueue_styles(): void
    {
        wp_enqueue_style('movie-database', plugin_dir_url(__FILE__) . 'css/movie-database-admin.css', [], MVDB_VERSION);
    }

    public function enqueue_scripts(): void
    {
        wp_enqueue_script('movie-database', plugin_dir_url(__FILE__) . 'js/movie-database-admin.js', ['jquery'], MVDB_VERSION, false);
    }
}