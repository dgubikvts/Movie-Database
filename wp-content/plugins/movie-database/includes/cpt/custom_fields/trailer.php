<?php
    if(isset($value))
        $video_id = attachment_url_to_postid($value);
?>

<div class="mvdb_box">
    <label for="mvdb_trailer"><?php esc_html_e('Trailer', 'movie-database') ?></label>
    <button id="mvdb_trailer_button" type="button"><?php esc_html_e('Izaberi trailer', 'movie-database') ?></button>
    <div class="mvdb_trailer_video">
        <?php if(isset($value)): ?>
            <video controls src="<?php echo $value ?? '' ?>" id="mvdb_trailer_video" width="200px" height="200px"/>
        <?php endif; ?>
    </div>
    <input type="hidden" id="mvdb_trailer" name="mvdb_trailer" value="<?php echo $video_id ?? '' ?>">
</div>