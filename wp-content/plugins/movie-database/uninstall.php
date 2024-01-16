<?php

if(!defined( 'WP_UNINSTALL_PLUGIN')){
    exit;
}

function mvdb_delete_plugin(): void
{
    global $wpdb;

    $posts = get_posts([
        'post_type' => 'film',
        'numberposts' => -1,
        'post_status' => 'any',
    ]);

    foreach($posts as $post){
        wp_delete_post($post->ID,true);
    }

    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}movie_database");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}movie_genres");
}

if(!defined('MVDB_VERSION')){
    mvdb_delete_plugin();
}
