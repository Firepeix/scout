<?php


namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\Sources\Source;
use App\Infrastructure\Sources\MklotSource;
use App\Infrastructure\Sources\MNatoSource;
use Illuminate\Database\Seeder;

class SourceSeeder  extends Seeder
{
    public function run() : void
    {
        $sources = [
            ['name' => 'Mkalot', 'type' => MklotSource::TYPE, 'template' => 'https://mangakakalot.com/${MANGA-ID}'],
            ['name' => 'MNato', 'type' => MNatoSource::TYPE, 'template' => 'https://readmanganato.com/${MANGA-ID}']
        ];
        $persistedSources = Source::all();
        foreach ($sources as $source) {
            if ($persistedSources->where('type', $source['type'])->isEmpty()) {
                $entity = new Source($source);
                $entity->save();
            }
        }
    }
}
