<?php

use Illuminate\Database\Seeder;

class HomeAddress extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\HomeAddress::class, 10)->create();
    }
}
