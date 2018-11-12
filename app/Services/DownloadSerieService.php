<?php


namespace App\Services;


use App\Exceptions\OmdbNoResultsException;
use GuzzleHttp\Client;

/**
 * Class DownloadSerieService
 * @package App
 */
class DownloadSerieService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * DownloadSerieService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return object
     * @throws OmdbNoResultsException
     */
    public function findSerie($serieName)
    {
        return $this->retrieveApiData(sprintf("http://www.omdbapi.com/?t=%s&apikey=%s", $serieName, config('services.omdb.key')));
    }

    /**
     * @param $serieName
     * @param $seasonNumber
     * @return object
     * @throws OmdbNoResultsException
     */
    public function findSerieSeason( $serieName, $seasonNumber)
    {
        return $this->retrieveApiData(sprintf("http://www.omdbapi.com/?t=%s&season=%s&apikey=%s", $serieName,$seasonNumber, config('services.omdb.key')));
    }

    /**
     * @param $query
     * @param $serieName
     * @param $seasonNumber
     * @param $episodeNumber
     * @return object
     * @throws \Exception
     */
    public function findSerieSeasonEpisode($query, $serieName, $seasonNumber, $episodeNumber)
    {
        return $this->retrieveApiData(sprintf("http://www.omdbapi.com/?t=%s&season=%s&episode=%s&apikey=%s", $serieName,$seasonNumber,$episodeNumber, config('services.omdb.key')));
    }

    /**
     * @param $url
     * @return object
     * @throws OmdbNoResultsException
     */
    private function retrieveApiData($url) {
        $response = $this->client->get($url);
        $data = \json_decode($response->getBody()->getContents());

        if ( $data->Response == "False" ) {
            throw new OmdbNoResultsException;
        }

        return (object)$data;
    }
}
