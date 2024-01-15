<?php

require_once MVDB_PLUGIN . 'includes/repository/class-movie-database-abstract-repository.php';

class MVDB_Genre_Repository extends MVDB_Abstract_Repository
{
    protected string $table_name = 'movie_genres';

    public function create_table(): void
    {
        $charset_collate = $this->wpdb->get_charset_collate();
        $sql = "CREATE TABLE $this->table_name (
          `id` mediumint(9) NOT NULL AUTO_INCREMENT,
          `term_id` bigint NOT NULL,
          `genre_id` bigint NOT NULL,
          PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function save(array $data): void
    {
        $this->insert($data);
    }
}