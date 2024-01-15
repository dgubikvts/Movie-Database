<?php

require_once MVDB_PLUGIN . 'includes/import/services/class-movie-database-abstract-import-service.php';
require_once MVDB_PLUGIN . 'includes/import/client/class-movie-database-image-client.php';
require_once MVDB_PLUGIN . 'includes/import/mapper/class-movie-database-image-import-mapper.php';

class MVDB_Image_Import_Service extends MVDB_Abstract_Import_Service
{
    public function __construct()
    {
        $this->client = new MVDB_Image_Client();
        $this->mapper = new MVDB_Image_Import_Mapper();
    }

    public function getData(): mixed
    {
        $response = $this->client->send();
        for($i = 0; $i < 3; $i ++){
            $data[] = $this->mapper->to($response[$i]);
        }

        return $this->prepareData($this->uploadImages($data ?? []));
    }

    private function uploadImages(array $images): array
    {
        foreach($images as $image){
            $file['name'] = basename($image['file']);
            $file['tmp_name'] = download_url($image['file']);
            $imageIDs[] = media_handle_sideload($file);
        }

        return $imageIDs ?? [];
    }

    protected function prepareData(mixed $data): mixed
    {
        return serialize(array_map('wp_get_attachment_url', $data));
    }
}