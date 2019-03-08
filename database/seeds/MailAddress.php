<?php

use Illuminate\Database\Seeder;

class MailAddress extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\MailAddress::class, 10)->create();
    }
}
