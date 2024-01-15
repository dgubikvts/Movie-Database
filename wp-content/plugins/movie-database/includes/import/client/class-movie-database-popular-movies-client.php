<?php

require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-abstract-client.php';

class MVDB_Popular_Movies_Client extends MVDB_Abstract_Client
{
    protected string $uri = '3/movie/popular';

    protected function formatResponse(array $response): array
    {
        return $response['results'];
    }
}