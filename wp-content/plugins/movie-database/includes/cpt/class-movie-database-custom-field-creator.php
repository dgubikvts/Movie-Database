<?php

require_once MVDB_PLUGIN . 'includes/repository/class-movie-database-movie-repository.php';

class MVDB_Custom_Field_Creator
{
    private MVDB_Movie_Repository $repository;

    public array $fields = [
        'gallery',
        'rating',
        'release_date',
        'genre',
        'cast',
        'trailer'
    ];

    public function __construct()
    {
        $this->repository = new MVDB_Movie_Repository();
    }

    public function create(): void
    {
        add_meta_box("mvdb_custom_fields", __('Additional Fields', 'movie-database'), [$this, "generate_custom_fields"], 'film');
    }

    public function generate_custom_fields(): void
    {
        wp_nonce_field('movie_database_custom_fields_nonce', 'movie_database_custom_fields' );
        global $post_id;
        foreach($this->fields as $key => $field){
            if(isset($post_id)) $value = sanitize_text_field($this->repository->getField($post_id, $field));
            require_once MVDB_PLUGIN . "includes/cpt/custom_fields/$field.php";
        }
    }

    public function save_custom_fields($post_id): void
    {
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if(!isset($_POST['movie_database_custom_fields'])) return;
        if (!wp_verify_nonce($_POST['movie_database_custom_fields'], 'movie_database_custom_fields_nonce')) return;
        $data = $this->prepareFields($_POST);
        $data['post_id'] = $post_id;
        $this->repository->save($data);
    }

    private function prepareFields(array $data): array
    {
        foreach ($this->fields as $field) {
            if(!isset($data["mvdb_{$field}"])) continue;
            $fields[$field] = $this->repository->prepareAttribute($field, is_array($data["mvdb_{$field}"]) ? array_map('sanitize_text_field', $data["mvdb_{$field}"]) : sanitize_text_field($data["mvdb_{$field}"]));
        }

        return $fields ?? [];
    }
}