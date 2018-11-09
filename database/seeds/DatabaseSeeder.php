<?php

use App\Episode;
use App\Serie;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Filesystem $filesystem)
    {
        foreach ($filesystem->allFiles(storage_path('seeds/series')) AS $file) {
            $serie = \json_decode($file->getContents());

            Serie::unguard();

            $years = array_filter(explode('–', $serie->Year));

            $startedAt = $years[0];
            $endedAt = $years[1] ?? null;


            Serie::firstOrCreate([
                'imdb_id' => $serie->imdbID,
            ], [
                'imdb_id' => $serie->imdbID,
                'title' => $serie->Title,
                'plot' => $serie->Plot,
                'rated' => $serie->Rated,
                'year_started_at' => $startedAt,
                'year_ended_at' => $endedAt,
            ]);
        }

        Serie::unguard();
        Episode::unguard();

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

            $serie->posters()->updateOrCreate(['url' => $serieData->Poster],[
                'url' => $serieData->Poster
            ]);

            foreach ($serieData->seasons AS $seasonFile) {
                $seasonData = \json_decode($filesystem->get(storage_path(sprintf('seeds/seasons/%s', $seasonFile))));

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
