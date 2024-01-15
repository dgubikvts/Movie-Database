<?php
    require_once MVDB_PLUGIN . "includes/repository/class-movie-database-genre-repository.php";
    $genre_repository = new MVDB_Genre_Repository();
    $value = unserialize($value ?? '');
    foreach($value as $item){
        $genres[] = $genre_repository->getFieldWhere('term_id', ['genre_id' => $item]);
    }
    $terms = get_terms([
        'taxonomy'      => 'kategorije',
        'hide_empty'    => false,
        'fields'        => 'id=>name'
    ]);
?>

<div class="mvdb_box">
    <label for="mvdb_genre"><?php esc_attr_e('Zanr', 'movie-database'); ?></label>
    <select name="mvdb_genre[]" multiple>
        <option disabled <?php echo count($genres ?? []) ? '' : 'selected' ?>><?php esc_attr_e('Odaberite zanr', 'movie-database'); ?></option>
        <?php foreach($terms as $id => $name): ?>
            <option value="<?php echo $id ?>" <?php echo in_array($id, $genres ?? []) ? 'selected' : ''  ?> ><?php echo $name ?></option>
        <?php endforeach; ?>
    </select>
</div>