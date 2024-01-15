<?php

require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-abstract-client.php';

class MVDB_Image_Client extends MVDB_Abstract_Client
{
    protected string $uri = '3/movie/{movie_id}/images';

    protected function formatResponse(array $response): array
    {
        return $response['posters'];
    }
}