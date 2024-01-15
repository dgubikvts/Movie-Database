<?php

require_once MVDB_PLUGIN . 'includes/import/services/class-movie-database-abstract-import-service.php';
require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-genre-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-genre-import-mapper.php';

class MVDB_Genre_Import_Service extends MVDB_Abstract_Import_Service
{
    public function __construct()
    {
        $this->client = new MVDB_Genre_Client();
        $this->mapper = new MVDB_Genre_Import_Mapper();
    }
}