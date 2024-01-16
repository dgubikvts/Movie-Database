<div class="wrap">
    <h1><?php echo get_admin_page_title() ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_fields('mvdb_settings');
            do_settings_sections('movie-database-options');
            submit_button();
        ?>
    </form>
</div>