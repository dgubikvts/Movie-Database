<?php

class MVDB_Form
{
    public function register_shortcode(): void
    {
        add_shortcode('mvdb_form', [$this, 'form_template']);
    }

    public function form_template(): string
    {
        ob_start();
        include MVDB_PLUGIN . 'includes/form/template.php';
        return ob_get_clean();
    }
}