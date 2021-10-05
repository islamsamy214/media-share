<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'email' => 'example@app.com',
            'facebook_id' => '/',
            'twitter_id' => '/',
            'linkedin_id' => '/',
            'instagram_id' => '/',
            'youtube_id' => '/'
        ]);
    }
}
