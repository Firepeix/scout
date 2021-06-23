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
        foreach ($sources as $source) {
            $entity = new Source($source);
            $entity->save();
        }
    }
}
