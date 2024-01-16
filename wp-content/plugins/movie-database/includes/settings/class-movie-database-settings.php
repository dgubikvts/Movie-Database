<?php

class MVDB_Settings
{
    public function register_mvdb_settings(): void
    {
        add_options_page('Movie Database Options',  'Movie Database Options', 'manage_options', 'movie-database-options', [$this, 'mvdb_print_options']);
        $this->add_settings_section('mvdb_section_1', '', '', 'movie-database-options');
        $this->register_setting('mvdb_settings', 'mvdb_tmdb_api_key', 'sanitize_text_field');
        $this->add_settings_field('mvdb_tmdb_api_key', esc_html__('"The Movie Database" API key', 'movie-database'), [$this, 'mvdb_api_key'], 'movie-database-options', 'mvdb_section_1');
        $this->register_setting('mvdb_settings', 'mvdb_form_shortcode', '');
        $this->add_settings_field('mvdb_form_shortcode', esc_html__('Form shortcode', 'movie-database'), [$this, 'mvdb_form_shortcode'], 'movie-database-options', 'mvdb_section_1');
    }

    public function mvdb_print_options(): void
    {
        require_once MVDB_PLUGIN . 'includes/settings/settings.php';
    }

    public function mvdb_api_key(): void
    {
        $value = get_option('mvdb_tmdb_api_key');
        $name = 'mvdb_tmdb_api_key';
        $readonly = false;
        include MVDB_PLUGIN . 'includes/settings/fields/text.php';
    }

    public function mvdb_form_shortcode(): void
    {
        $value = '[mvdb_form]';
        $name = 'mvdb_form_shortcode';
        $readonly = true;
        include MVDB_PLUGIN . 'includes/settings/fields/text.php';
    }

    private function add_settings_section(string $id, string $title, string|array $callback, string $page): void
    {
        add_settings_section($id, $title, $callback, $page);
    }

    private function register_setting(string $option_group, string $option_name, string|array $callback): void
    {
        register_setting($option_group, $option_name, $callback);
    }

    private function add_settings_field(string $id, string $title, string|array $callback, string $page, string $section): void
    {
        add_settings_field($id, $title, $callback, $page, $section);
    }
}