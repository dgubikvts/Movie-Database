<?php

require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-abstract-import-mapper.php';
include_once(ABSPATH . 'wp-admin/includes/admin.php');

class MVDB_Image_Import_Mapper extends MVDB_Abstract_Import_Mapper
{
    protected array $fields = [
        'file_path' => 'file'
    ];

    protected function prepareFilePathAttribute(mixed $value): string
    {
        return "https://image.tmdb.org/t/p/original/$value";
    }
}