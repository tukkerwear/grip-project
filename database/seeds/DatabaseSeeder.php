<?php

use App\Episode;
use App\Serie;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Some quick seeding to make testing easier.
     *
     * @param Filesystem $filesystem
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run(Filesystem $filesystem)
    {

        /*
         * Create a user
         */

        factory(\App\User::class)->create([
            'name' => 'Dirk',
            'email' => 'test@test.nl',
        ]);


        /*
         * Iterate over all series
         */
        foreach ($filesystem->allFiles(storage_path('seeds/series')) AS $serieFile) {
            $serieData = \json_decode($serieFile->getContents());

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
            $serie->posters()->updateOrCreate(['url' => $serieData->Poster],[
                'url' => $serieData->Poster
            ]);


            /*
             * Create and sync genres for this serie.
             */
            $genres = explode(", ", $serieData->Genre);
            $genresForSerie = [];
            foreach($genres AS $genre){
                $genre = \App\Genre::updateOrCreate([
                    'title' => $genre
                ]);

                $genresForSerie[] = $genre->id;
            }

            $serie->genres()->syncWithoutDetaching($genresForSerie);


            /*
             * Iterate over the season files for this serie.
             */
            foreach ($serieData->seasons AS $seasonFile) {
                $seasonData = \json_decode($filesystem->get(storage_path(sprintf('seeds/seasons/%s', $seasonFile))));

                /*
                 * Create all episodes based on the season file
                 * REMINDER: When enriching the database  fetch the episode files as well.
                 */
                foreach ($seasonData->Episodes AS $episodeData) {
                    $serie->episodes()->updateOrCreate(
                        ['imdb_id' => $episodeData->imdbID],
                        [
                            'title' => $episodeData->Title,
                            'season' => $seasonData->Season,
                            'episode' => $episodeData->Episode,
                            'released_at' => $episodeData->Released,
                        ]
                    );
                }
            }
        }
    }
}
