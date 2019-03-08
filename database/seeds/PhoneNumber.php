<?php

use Illuminate\Database\Seeder;

class PhoneNumber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PhoneNumber::class, 10)->create();
    }
}
