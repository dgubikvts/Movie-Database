<?php

class MVDB_Public
{
    public function enqueue_styles(): void
    {
        wp_enqueue_style('movie-database', plugin_dir_url(__FILE__) . 'css/movie-database-public.css', [], MVDB_VERSION);
    }

    public function enqueue_scripts(): void
    {
        wp_enqueue_script('movie-database', plugin_dir_url(__FILE__) . 'js/movie-database-public.js', ['jquery'], MVDB_VERSION, false);
        wp_localize_script('movie-database', 'global', ['ajax_url' => admin_url( 'admin-ajax.php' )]);
    }
}