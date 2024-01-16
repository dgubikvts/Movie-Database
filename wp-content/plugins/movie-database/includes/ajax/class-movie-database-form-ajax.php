<?php

require_once MVDB_PLUGIN . 'includes/ajax/class-movie-database-abstract-ajax.php';

class MVDB_Form_Ajax extends MVDB_Abstract_Ajax
{
    protected array $nonce = [
        'mvdb_form_security' => 'mvdb_form_security_nonce'
    ];

    protected array $fields = [
        'fname',
        'lname',
        'email',
        'movie',
        'opinion'
    ];

    protected string $method = 'POST';

    protected function send_response()
    {
        $this->send_mail();
        wp_send_json_success(['message' => esc_html__("Poruka je uspešno poslata!", 'movie-database')]);
    }

    private function send_mail()
    {
        $to = sanitize_text_field(get_option('admin_email'));
        $movie = sanitize_text_field($this->data['movie']);
        $subject = sprintf(esc_html__('Mišljenje o filmu: %s', 'movie-database'), $movie);
        $message = $this->getEmailMessage([
            'fname' => sanitize_text_field($this->data['fname']),
            'lname' => sanitize_text_field($this->data['lname']),
            'email' => sanitize_text_field($this->data['email']),
            'opinion' => sanitize_text_field($this->data['opinion']),
        ]);
        wp_mail($to, $subject, $message, ['Content-Type: text/html; charset=UTF-8']);
    }

    private function getEmailMessage(array $data): string
    {
        return "
            <p>" . sprintf(esc_html__('Korisnik %1$s %2$s sa email adresom %3$s kaže:', 'movie-database'), $data['fname'], $data['lname'], $data['email']) . "</p>
            <p> " . $data['opinion'] . "</p>
        ";
    }

    protected function validate_fname(mixed $value)
    {
        if(strlen($value) < 2) $this->errors[] = ['for' => 'fname', 'message' => esc_html__('Ime mora imati više od dva jednog karaktera', 'movie-database')];
        else if(strlen($value) > 25) $this->errors[] = ['for' => 'fname', 'message' => esc_html__('Ime mora imati manje od 25 karaktera', 'movie-database')];
    }

    protected function validate_lname(mixed $value)
    {
        if(strlen($value) < 2) $this->errors[] = ['for' => 'lname', 'message' => esc_html__('Prezime mora imati više od dva jednog karaktera', 'movie-database')];
        else if(strlen($value) > 25) $this->errors[] = ['for' => 'lname', 'message' => esc_html__('Prezime mora imati manje od 25 karaktera', 'movie-database')];
    }

    protected function validate_email(mixed $value)
    {
        if(!is_email($value)) $this->errors[] = ['for' => 'email', 'message' => esc_html__('Uneta je nevažeća email adresa', 'movie-database')];
    }

    protected function validate_movie(mixed $value)
    {
        $movies = get_posts(['post_status' => 'any', 'post_type' => 'film', 'title' => $value, 'fields' => 'ids']);
        if(!isset($movies[0])) $this->errors[] = ['for' => 'movie', 'message' => esc_html__('Naziv filma koji ste uneli je nepostojeći', 'movie-database')];
    }

    protected function validate_opinion(mixed $value)
    {
        if(strlen($value) < 20) $this->errors[] = ['for' => 'opinion', 'message' => esc_html__('Morate dati opširnije mišljenje', 'movie-database')];
        else if(strlen($value) > 500) $this->errors[] = ['for' => 'opinion', 'message' => esc_html__('Prekoračili ste limit od 500 karaktera', 'movie-database')];
    }
}