<?php

namespace App\Console\Commands;

use App\Models\Characters;
use App\Models\Episodes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportRickAndMortyData extends Command
{
    protected $signature = 'import:rickandmorty';
    protected $description = 'Import Rick and Morty characters and episodes';

    public function handle()
    {
        $this->importCharacters();
        $this->importEpisodes();
        $this->info('Import completed successfully!');
    }

    protected function importCharacters()
    {
        $response = Http::get('https://rickandmortyapi.com/api/character');
        $characters = $response->json()['results'];
        foreach (array_slice($characters, 0, 10) as $characterData) {
            Characters::updateOrCreate(
                ['id' => $characterData['id']],
                [
                    'name' => $characterData['name'],
                    'status' => $characterData['status'],
                    'species' => $characterData['species'],
                    'type' => $characterData['type'],
                    'gender' => $characterData['gender'],
                    'origin' => $characterData['origin'],
                    'location' => $characterData['location'],
                    'image' => $characterData['image'],
                    'url' => $characterData['url'],
                    'created_at' => $characterData['created'],
                ]
            );
        }
    }

    protected function importEpisodes()
    {
        $response = Http::get('https://rickandmortyapi.com/api/episode');
        $episodes = $response->json()['results'];

        foreach (array_slice($episodes, 0, 10) as $episodeData) {
            Episodes::updateOrCreate(
                ['id' => $episodeData['id']],
                [
                    'name' => $episodeData['name'],
                    'air_date' => $episodeData['air_date'],
                    'episode' => $episodeData['episode'],
                    'url' => $episodeData['url'],
                    'created_at' => $episodeData['created'],
                ]
            );
        }
    }
}
