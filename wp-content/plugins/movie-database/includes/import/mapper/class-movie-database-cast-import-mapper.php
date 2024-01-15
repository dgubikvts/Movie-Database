<?php

require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-abstract-import-mapper.php';

class MVDB_Cast_Import_Mapper extends MVDB_Abstract_Import_Mapper
{
    protected array $fields = [
        'name' => 'cast'
    ];
}