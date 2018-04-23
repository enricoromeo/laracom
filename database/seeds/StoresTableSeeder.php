<?php

use App\Shop\Stores\Store;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    public function run()
    {
        factory(Store::class)->create();
    }
}
