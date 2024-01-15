<?php

require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-abstract-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-abstract-import-mapper.php';

abstract class MVDB_Abstract_Import_Service
{
    protected MVDB_Abstract_Import_Mapper $mapper;

    protected MVDB_Abstract_Client $client;

    public function getData(): mixed
    {
        foreach($this->client->send() as $item){
            $data[] = $this->mapper->to($item);
        }

        return $this->prepareData($data ?? []);
    }

    public function prepareClientUri(string $movie_id): static
    {
        $this->client->prepareUri($movie_id);
        return $this;
    }

    protected function prepareData(mixed $data): mixed
    {
        return $data;
    }
}