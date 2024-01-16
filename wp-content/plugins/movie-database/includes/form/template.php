<form id="mvdb_form">
    <label for="mvdb_fname"> <?php esc_html_e('Ime', 'movie-database'); ?>
        <input type="text" name="mvdb_fname" id="mvdb_fname"/>
    </label>
    <label id="mvdb_fname_error"></label>
    <label for="mvdb_lname"> <?php esc_html_e('Prezime', 'movie-database'); ?>
        <input type="text" name="mvdb_lname" id="mvdb_lname"/>
    </label>
    <label id="mvdb_lname_error"></label>
    <label for="mvdb_email"> <?php esc_html_e('E-mail adresa', 'movie-database'); ?>
        <input type="email" name="mvdb_email" id="mvdb_email"/>
    </label>
    <label id="mvdb_email_error"></label>
    <label for="mvdb_movie"> <?php esc_html_e('Naziv filma', 'movie-database'); ?>
        <input type="text" name="mvdb_movie" id="mvdb_movie"/>
    </label>
    <label id="mvdb_movie_error"></label>
    <label for="mvdb_opinion"> <?php esc_html_e('Vaše mišljenje', 'movie-database'); ?>
        <textarea name="mvdb_opinion" id="mvdb_opinion"></textarea>
    </label>
    <label id="mvdb_opinion_error"></label>
    <?php wp_nonce_field('mvdb_form_security_nonce', 'mvdb_form_security'); ?>
    <button type="submit"><?php esc_html_e('Pošalji', 'movie-database'); ?></button>
    <label id="mvdb_success"></label>
</form>