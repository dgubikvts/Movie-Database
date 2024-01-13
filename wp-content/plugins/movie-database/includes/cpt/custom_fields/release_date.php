<div class="mvdb_box">
    <label for="mvdb_release_date"><?php esc_html_e('Datum izlaska', 'movie-database') ?></label>
    <input id="mvdb_release_date" type="date" name="mvdb_release_date" value="<?php echo wp_date('Y-m-d', strtotime(esc_html($value ?? ''))) ?>">
</div>