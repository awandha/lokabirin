<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
    $posts = Post::take(5)->get();

    foreach ($posts as $post) {
        Comment::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
                'content' => 'This is a test comment.',
            ]);
        }
    }
}
