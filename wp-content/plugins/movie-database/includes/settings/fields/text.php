<label for="<?php echo $name ?>"> <?php echo $label ?? ''?>
    <input <?php echo $readonly ? 'readonly' : '' ?> type="text" name="<?php echo $name ?>" value="<?php echo $value ?? '' ?>"/>
</label>