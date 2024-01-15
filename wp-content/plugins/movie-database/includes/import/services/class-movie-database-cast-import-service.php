<?php

require_once MVDB_PLUGIN . 'includes/import/services/class-movie-database-abstract-import-service.php';
require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-cast-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-cast-import-mapper.php';

class MVDB_Cast_Import_Service extends MVDB_Abstract_Import_Service
{
    public function __construct()
    {
        $this->client = new MVDB_Cast_Client();
        $this->mapper = new MVDB_Cast_Import_Mapper();
    }

    protected function prepareData(mixed $data): string
    {
        return implode(', ', array_merge_recursive(...$data)['cast']);
    }
}