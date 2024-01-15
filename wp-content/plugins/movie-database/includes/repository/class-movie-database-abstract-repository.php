<?php

abstract class MVDB_Abstract_Repository
{
    protected wpdb $wpdb;

    protected string $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = "{$this->wpdb->prefix}{$this->table_name}";
    }

    abstract public function create_table(): void;

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

    public function getFieldWhere(string $field, array $condition)
    {
        $key = array_key_first($condition);
        $query = $this->wpdb->prepare("SELECT {$field} FROM {$this->table_name} WHERE `$key` = '%s'", $condition[$key]);
        return $this->wpdb->get_row($query)?->$field;
    }


    public function prepareAttribute(string $attribute, mixed $value)
    {
        $formatted_attribute = str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $method = "prepare{$formatted_attribute}Attribute";
        if(method_exists($this, $method)) return $this->$method($value);
        return $value;
    }

    protected function exists(string $post_id): bool
    {
        $query = $this->wpdb->prepare("SELECT id FROM {$this->table_name} WHERE `post_id` = '%s'", $post_id);
        return (bool) $this->wpdb->get_results($query);
    }

    protected function update(array $data): void
    {
        $this->wpdb->update($this->table_name, $data, ['post_id' => $data['post_id']]);
    }

    protected function insert(array $data): void
    {
        $this->wpdb->insert($this->table_name, $data);
    }
}