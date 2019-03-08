<?php

use Illuminate\Database\Seeder;

class ContactOwner extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ContactOwner::class, 10)->create();
    }
}
