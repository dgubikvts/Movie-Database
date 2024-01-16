<?php

abstract class MVDB_Abstract_Client
{
    protected string $base_url = 'https://api.themoviedb.org';

    protected false|CurlHandle $curl;

    protected string $uri;

    protected string $replacedUri;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function send(): array
    {
        $uri = $this->replacedUri ?? $this->uri;
        curl_setopt($this->curl, CURLOPT_URL, $this->authorize("$this->base_url/{$uri}"));
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($this->curl);
        curl_close($this->curl);

        return $this->formatResponse(json_decode($response,true));
    }

    private function authorize(string $url): string
    {
        $api_key = sanitize_text_field(get_option('mvdb_tmdb_api_key'));
        return "$url?api_key=$api_key";
    }

    protected function formatResponse(array $response): array
    {
        return $response;
    }

    public function prepareUri(string $movie_id): static
    {
        $this->replacedUri = str_replace('{movie_id}', $movie_id, $this->uri);
        return $this;
    }
}