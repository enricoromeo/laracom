<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Shop\Stores\Store;
use Illuminate\Http\UploadedFile;

$factory->define(Store::class, function (Faker\Generator $faker) {
    $store = $faker->unique()->sentence;
    $file = UploadedFile::fake()->image('store.png', 600, 600);

    return [
        'name' => $store,
        'slug' => str_slug($store),
        'description' => $this->faker->paragraph,
        'cover' => $file->store('stores', ['disk' => 'public']),
        'status' => 1
    ];
});
