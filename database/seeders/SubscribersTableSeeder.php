<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            Subscriber::factory(rand(300, 500))->create([
                'user_id' => $user->id,
                'created_at' => now()->subDays(rand(0, 90)),
            ]);
        });
    }
}
