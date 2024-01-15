<?php

require_once MVDB_PLUGIN . 'includes/repository/class-movie-database-abstract-repository.php';

class MVDB_Movie_Repository extends MVDB_Abstract_Repository
{
    protected string $table_name = 'movie_database';

    public function create_table(): void
    {
        $charset_collate = $this->wpdb->get_charset_collate();
        $sql = "CREATE TABLE $this->table_name (
          `id` mediumint(9) NOT NULL AUTO_INCREMENT,
          `post_id` bigint NOT NULL,
          `gallery` LONGTEXT NOT NULL,  
          `rating` varchar(255) NOT NULL,
          `release_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `genre` LONGTEXT NOT NULL,
          `cast` LONGTEXT NOT NULL,
          `trailer` LONGTEXT NOT NULL,
          PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    protected function prepareGenreAttribute(mixed $value)
    {
        return serialize($value);
    }

    protected function prepareGalleryAttribute(mixed $value)
    {
        if(strlen($value) > 0) $ids = explode(',', $value);
        foreach($ids ?? [] as $id){
            $images[] = wp_get_attachment_url($id);
        }
        return isset($images) ? serialize($images) : '';
    }
}