<?php

class MVDB_Repository
{
    private wpdb $wpdb;

    private string $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $this->wpdb->prefix . 'movie_database';
    }

    public function create_table(): void
    {
        $charset_collate = $this->wpdb->get_charset_collate();
        $sql = "CREATE TABLE $this->table_name (
          `id` mediumint(9) NOT NULL AUTO_INCREMENT,
          `post_id` bigint NOT NULL,
          `gallery` LONGTEXT NOT NULL,  
          `rating` varchar(255) NOT NULL,
          `release_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `genre` varchar(255) NOT NULL,
          `cast` varchar(255) NOT NULL,  
          `trailer` LONGTEXT NOT NULL,  
          PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function save(array $data): void
    {
        if(!isset($data['post_id']) || count($data) < 2) return;
        if($this->exists($data['post_id'])) $this->update($data);
        else $this->insert($data);
    }

    public function getField(string $post_id, string $field)
    {
        $query = $this->wpdb->prepare("SELECT {$field} FROM {$this->table_name} WHERE `post_id` = '%s'", $post_id);
        return $this->wpdb->get_row($query)?->$field;
    }

    public function prepareAttribute(string $attribute, mixed $value)
    {
        $formatted_attribute = str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $method = "prepare{$formatted_attribute}Attribute";
        if(method_exists($this, $method)) return $this->$method($value);
        return $value;
    }

    private function prepareGenreAttribute(mixed $value)
    {
        return get_term_by('id', $value, 'kategorije', ARRAY_A)['name'];
    }

    private function prepareGalleryAttribute(mixed $value)
    {
        $images = [];
        foreach(explode(',', $value) as $id){
            $images[] = wp_get_attachment_url($id);
        }
        return serialize($images);
    }

    private function prepareTrailerAttribute(mixed $value)
    {
        return wp_get_attachment_url($value);
    }

    private function exists(string $post_id): bool
    {
        $query = $this->wpdb->prepare("SELECT id FROM {$this->table_name} WHERE `post_id` = '%s'", $post_id);
        return (bool) $this->wpdb->get_results($query);
    }

    private function update(array $data): void
    {
        $this->wpdb->update($this->table_name, $data, ['post_id' => $data['post_id']]);
    }

    private function insert(array $data): void
    {
        $this->wpdb->insert($this->table_name, $data);
    }
}