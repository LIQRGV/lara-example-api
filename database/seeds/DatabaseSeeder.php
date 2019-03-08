<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContactOwner::class);
        $this->call(HomeAddress::class);
        $this->call(MailAddress::class);
        $this->call(PhoneNumber::class);
    }
}
