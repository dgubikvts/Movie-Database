<?php

class MVDB_Deactivator
{
    public static function deactivate(): void
    {
        unregister_post_type('film');
        flush_rewrite_rules();
        remove_shortcode('mvdb_form');
        wp_unschedule_event(wp_next_scheduled('mvdb_import_movies_hook'), 'mvdb_import_movies_hook');
    }
}