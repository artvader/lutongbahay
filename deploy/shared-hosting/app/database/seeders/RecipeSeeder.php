<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('username', 'admin')->first();
        if (!$admin) {
            return;
        }

        $file = database_path('seeders/recipes.seed.json');
        if (!file_exists($file)) {
            return;
        }

        $rows = json_decode(file_get_contents($file), true);
        if (!is_array($rows)) {
            return;
        }

        foreach ($rows as $item) {
            Recipe::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'external_id' => (string) $item['id'],
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'description' => $item['description'] ?? null,
                    'image_url' => $item['imageUrl'] ?? null,
                    'image_alt' => $item['imageAlt'] ?? null,
                    'prep_mins' => (int) ($item['prepMins'] ?? 0),
                    'cook_mins' => (int) ($item['cookMins'] ?? 0),
                    'difficulty' => $item['difficulty'] ?? null,
                    'rating' => (float) ($item['rating'] ?? 0),
                    'rating_count' => (int) ($item['ratingCount'] ?? 0),
                    'region' => $item['region'] ?? null,
                    'course' => $item['course'] ?? null,
                    'main_ingredient' => $item['mainIngredient'] ?? null,
                    'featured' => (bool) ($item['featured'] ?? false),
                    'ingredients' => $item['ingredients'] ?? [],
                    'steps' => $item['steps'] ?? [],
                    'excerpt' => $item['description'] ?? null,
                    'content' => implode(PHP_EOL . PHP_EOL, $item['steps'] ?? []),
                    'status' => 'published',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                ]
            );
        }
    }
}
