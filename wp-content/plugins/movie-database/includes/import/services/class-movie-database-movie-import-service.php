<?php

require_once MVDB_PLUGIN . 'includes/import/services/class-movie-database-abstract-import-service.php';
require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-popular-movies-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-movie-import-mapper.php';

class MVDB_Movie_Import_Service extends MVDB_Abstract_Import_Service
{
    public function __construct()
    {
        $this->client = new MVDB_Popular_Movies_Client();
        $this->mapper = new MVDB_Movie_Import_Mapper();
    }
}