<?php

require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-abstract-import-mapper.php';

class MVDB_Trailer_Import_Mapper extends MVDB_Abstract_Import_Mapper
{
    protected array $fields = [
        'key' => 'trailer'
    ];

    protected function prepareKeyAttribute(mixed $value): string
    {
        return "https://www.youtube.com/watch?v=$value";
    }
}