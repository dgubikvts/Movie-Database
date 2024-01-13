<?php
    $terms = get_terms([
        'taxonomy'      => 'kategorije',
        'hide_empty'    => false,
        'fields'        => 'id=>name'
    ]);
?>

<div class="mvdb_box">
    <label for="mvdb_genre"><?php esc_attr_e('Zanr', 'movie-database'); ?></label>
    <select name="mvdb_genre">
        <option disabled selected><?php esc_attr_e('Odaberite zanr', 'movie-database'); ?></option>
        <?php foreach($terms as $id => $name): ?>
            <option value="<?php echo $id ?>" <?php selected($name, esc_html($value ?? '')) ?> ><?php echo $name ?></option>
        <?php endforeach; ?>
    </select>
</div>