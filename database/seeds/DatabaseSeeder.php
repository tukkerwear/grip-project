<?php

use App\Episode;
use App\Serie;
use App\Services\DownloadSerieService;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Some quick seeding to make testing easier.
     *
     * @param Filesystem $filesystem
     * @param DownloadSerieService $downloadSerieService
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run(Filesystem $filesystem, DownloadSerieService $downloadSerieService)
    {

        /*
         * Create a user
         */

//        factory(\App\User::class)->create([
//            'name' => 'Dirk',
//            'email' => 'test@test.nl',
//        ]);


        $serieNames = [
            "Game of Thrones",
            "Mayans MC",
            "The Last Ship",
            "The Purge",
            "Titans",
            "Silicon Valley",
            "A Discovery of witches",
            "The Good Place",
            "Manifest",
            "Legacies",
        ];

        foreach ($serieNames AS $serieName) {
            $serieData = $downloadSerieService->findSerie($serieName);
            dump($serieData);
            $serie = $this->storeSerie($serieData);

            for ($i = $serieData->totalSeasons ?? 1; $i > 0; $i--) {
                $episodeData = $downloadSerieService->findSerieSeason($serieName, $i);
                $this->storeSerieSeason($serie, $episodeData);
            }
        }
    }
    
    /**
     * @param $serieData
     * @param $startedAt
     * @param $endedAt
     * @return mixed
     */
    public function storeSerie($serieData)
    {
        $years = array_filter(explode('–', $serieData->Year));
        $startedAt = $years[0];
        $endedAt = $years[1] ?? null;

        $serie = Serie::updateOrCreate(['imdb_id' => $serieData->imdbID],
            [
                'imdb_id' => $serieData->imdbID,
                'title' => $serieData->Title,
                'plot' => $serieData->Plot,
                'rated' => $serieData->Rated,
                'year_started_at' => $startedAt,
                'year_ended_at' => $endedAt,
            ]);

        /*
         * Attach the related poster to the current serie.
         */
        $serie->posters()->updateOrCreate(['url' => $serieData->Poster], [
            'url' => $serieData->Poster,
        ]);

        $genres = explode(", ", $serieData->Genre);
        $genresForSerie = [];
        foreach ($genres AS $genre) {
            $genre = \App\Genre::updateOrCreate([
                'title' => $genre,
            ]);

            $genresForSerie[] = $genre->id;
        }

        $serie->genres()->syncWithoutDetaching($genresForSerie);

        return $serie;
    }

    public function storeSerieSeason($serie, $seasonData)
    {
        foreach ($seasonData->Episodes AS $episodeData) {
            $serie->episodes()->updateOrCreate(
                ['imdb_id' => $episodeData->imdbID],
                [
                    'title' => $episodeData->Title,
                    'season' => $seasonData->Season,
                    'episode' => $episodeData->Episode,
                    'released_at' => $episodeData->Released == "N/A" ? null : $episodeData->Released,
                ]
            );
        }
    }
}
