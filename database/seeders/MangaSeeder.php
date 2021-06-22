<?php


namespace Database\Seeders;


use App\Infrastructure\Persistence\Models\Mangas\Manga;
use App\Infrastructure\Sources\MklotSource;
use Illuminate\Database\Seeder;

class MangaSeeder  extends Seeder
{
    public function run() : void
    {
        $mangas = [
            ['name' => 'Nozomanu Fushi no Boukensha', 'last_read_chapter' => 0, 'sources' => [
                ['type' => MklotSource::TYPE, 'external_id' => 'read-er5ni158504847411']
            ]]
        ];
        foreach ($mangas as $manga) {
            $entity = new Manga($manga);
            $entity->save();
        }
    }
}
