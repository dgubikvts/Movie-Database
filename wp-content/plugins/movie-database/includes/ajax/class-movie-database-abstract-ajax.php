<?php

abstract class MVDB_Abstract_Ajax
{
    protected array $nonce;

    protected array $fields;

    protected string $method = 'GET';

    protected array $errors;

    protected array $data;

    public function __construct()
    {
        $this->data = $this->method == 'GET' ? $_GET : $_POST;
    }

    public function submit(): void
    {
        $this->verifyNonce();
        $this->validate_fields();
        $this->send_response();
    }

    protected function verifyNonce(): void
    {
        if(!isset($this->data[array_key_first($this->nonce)]) || !wp_verify_nonce($this->data[array_key_first($this->nonce)], array_values($this->nonce)[0]))
            wp_send_json_error(['error' => esc_html__('Napad detektovan', 'movie-database')], 422);
    }

    protected function validate_fields(): void
    {
        foreach($this->fields as $field){
            $method = "validate_$field";
            if(method_exists($this, $method)) $this->$method($this->data[$field]);
        }
        if(isset($this->errors) && count($this->errors)) wp_send_json_error($this->errors, 422);
    }

    abstract protected function send_response();
}