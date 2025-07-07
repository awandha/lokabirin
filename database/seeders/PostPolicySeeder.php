<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class PostPolicySeeder extends Seeder
{
    public function run(): void
    {
        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
        ]);

        $nonAuthor = User::create([
            'name' => 'Non Author User',
            'email' => 'nonauthor@example.com',
            'password' => Hash::make('password'),
        ]);

        Post::create([
            'title' => 'Seeder Post',
            'content' => 'Ini adalah post oleh Author User',
            'slug' => 'seeder-post',
            'user_id' => $author->id,
        ]);

        echo "Seeder done! Author: author@example.com | Non-Author: nonauthor@example.com | Password: password\n";
    }
}
