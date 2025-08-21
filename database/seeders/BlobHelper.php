<?php

namespace Database\Seeders;

use App\Models\Blob;
use Faker\Generator;
use Illuminate\Container\Container;

trait BlobHelper
{
    public function createBlob($identifier, $url = null): Blob
    {
        $faker = Container::getInstance()->make(Generator::class);

        if ($url == null)
            $url = $faker->imageUrl;

        $blob = new Blob();
        $blob->fill([
            'url' => $url,
            'name' => $faker->name,
            'size' => $faker->numberBetween(100, 230),
            'ext' => $faker->numberBetween(100, 230),
            'type' => $faker->name,
        ])->save();

        return $blob;
    }
}
