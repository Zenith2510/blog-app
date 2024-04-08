<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>  Hash::make('password'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' =>  Hash::make('password'),
        ]);
        $faker = Factory::create();

        // Create 5 tags with unique names
        $tags = [];
        for ($i = 0; $i < 5; $i++) {
            $tags[] = [
                'name' => $faker->unique()->word(),
            ];
        }
        Tag::insert($tags);

        $tagIds = Tag::pluck('id')->toArray(); // Get all tag IDs for random assignment

        // Create 10 posts with random titles, content, and tag associations
        $posts = [];
        for ($i = 0; $i < 50; $i++) {
            $posts[] = [
                'title' => $faker->title(),
                'content' => $faker->paragraphs(random_int(3, 7), true),
                'tag_id' => rand(1, 5), // Random tag ID from all tags
                'user_id' => rand(1, 2),
            ];
        }
        Post::insert($posts);
    }
}
