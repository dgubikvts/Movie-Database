<?php

abstract class MVDB_Abstract_Client
{
    protected string $base_url = 'https://api.themoviedb.org';

    protected false|CurlHandle $curl;

    protected string $uri;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function send()
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->authorize("$this->base_url/$this->uri"));
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
        $response  = curl_exec($this->curl);
        curl_close($this->curl);

        return $this->formatResponse(json_decode($response,true));
    }

    private function authorize(string $url): string
    {
        //TODO: Add api_key to url
        return $url;
    }

    protected function formatResponse(array $response): array
    {
        return $response;
    }

    public function prepareUri(string $movie_id): static
    {
        $this->uri = str_replace('{movie_id}', $movie_id, $this->uri);
        return $this;
    }
}