<?php
    if(isset($value)){
        $images = unserialize($value);
        $ids = '';
        foreach($images as $key => $image){
            $ids .= attachment_url_to_postid($image);
            if($key !== count($images) - 1) $ids .= ',';
        }
    }
?>

<div class="mvdb_box">
    <label for="mvdb_gallery"><?php esc_html_e('Galerija', 'movie-database') ?></label>
    <button id="mvdb_gallery_button" type="button"><?php esc_html_e('Izaberi slike', 'movie-database') ?></button>
    <div class="mvdb_gallery_images">
        <?php if(isset($images)): ?>
            <?php foreach($images as $image): ?>
                <img src="<?php echo $image ?>" id="mvdb_gallery_image" width="200px" height="200px" />
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <input type="hidden" id="mvdb_gallery" name="mvdb_gallery" value="<?php echo $ids ?? '' ?>">
</div>