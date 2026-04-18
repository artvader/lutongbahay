<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;

class RecipeApiController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('status', 'published')
            ->orderByDesc('featured')
            ->orderBy('title')
            ->get();

        return response()->json($recipes->map(fn (Recipe $recipe) => $this->transform($recipe))->values());
    }

    public function show(string $slug)
    {
        $recipe = Recipe::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($this->transform($recipe));
    }

    private function transform(Recipe $recipe): array
    {
        return [
            'id' => (string) ($recipe->external_id ?: $recipe->id),
            'slug' => $recipe->slug,
            'title' => $recipe->title,
            'description' => $recipe->description ?? $recipe->excerpt ?? '',
            'imageUrl' => $this->resolveImageUrl($recipe->image_url),
            'imageAlt' => $recipe->image_alt ?? $recipe->title,
            'prepMins' => (int) $recipe->prep_mins,
            'cookMins' => (int) $recipe->cook_mins,
            'difficulty' => $recipe->difficulty ?? 'Easy',
            'rating' => (float) $recipe->rating,
            'ratingCount' => (int) $recipe->rating_count,
            'region' => $recipe->region ?? 'National',
            'course' => $recipe->course ?? 'Main',
            'mainIngredient' => $recipe->main_ingredient ?? 'Mixed',
            'featured' => (bool) $recipe->featured,
            'ingredients' => $recipe->ingredients ?? [],
            'steps' => $recipe->steps ?? [],
        ];
    }

    private function resolveImageUrl(?string $imageUrl): string
    {
        if (! $imageUrl) {
            return '';
        }

        if (preg_match('/^https?:\/\//i', $imageUrl)) {
            return $imageUrl;
        }

        $normalizedPath = ltrim($imageUrl, '/');

        return url($normalizedPath);
    }
}
