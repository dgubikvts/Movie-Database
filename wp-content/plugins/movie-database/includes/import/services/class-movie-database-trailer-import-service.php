<?php

require_once MVDB_PLUGIN . 'includes/import/services/class-movie-database-abstract-import-service.php';
require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-trailer-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-trailer-import-mapper.php';

class MVDB_Trailer_Import_Service extends MVDB_Abstract_Import_Service
{
    public function __construct()
    {
        $this->client = new MVDB_Trailer_Client();
        $this->mapper = new MVDB_Trailer_Import_Mapper();
    }

    public function getData(): mixed
    {
        foreach($this->client->send() as $item){
            if($item['type'] != "Trailer") continue;
            return $this->prepareData($this->mapper->to($item));
        }

        return '';
    }

    protected function prepareData(mixed $data): mixed
    {
        return $data['trailer'];
    }
}