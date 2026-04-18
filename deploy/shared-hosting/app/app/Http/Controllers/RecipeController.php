<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor')->except(['index', 'show']);
    }

    public function index()
    {
        $recipes = Recipe::with('author')->latest()->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:recipes,slug'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'prep_mins' => ['nullable', 'integer', 'min:0'],
            'cook_mins' => ['nullable', 'integer', 'min:0'],
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'rating_count' => ['nullable', 'integer', 'min:0'],
            'region' => ['nullable', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],
            'main_ingredient' => ['nullable', 'string', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'ingredients_text' => ['nullable', 'string'],
            'steps_text' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $validated = $this->prepareRecipePayload($validated);
        $validated['author_id'] = $request->user()->id;
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('status', 'Recipe created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:recipes,slug,'.$recipe->id],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'prep_mins' => ['nullable', 'integer', 'min:0'],
            'cook_mins' => ['nullable', 'integer', 'min:0'],
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'rating_count' => ['nullable', 'integer', 'min:0'],
            'region' => ['nullable', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],
            'main_ingredient' => ['nullable', 'string', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'ingredients_text' => ['nullable', 'string'],
            'steps_text' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $validated = $this->prepareRecipePayload($validated);
        $validated['published_at'] = $validated['status'] === 'published'
            ? ($recipe->published_at ?? now())
            : null;

        $recipe->update($validated);

        return redirect()->route('recipes.index')->with('status', 'Recipe updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('status', 'Recipe deleted.');
    }

    private function prepareRecipePayload(array $validated): array
    {
        $ingredientsText = $validated['ingredients_text'] ?? '';
        $stepsText = $validated['steps_text'] ?? '';

        $validated['featured'] = (bool) ($validated['featured'] ?? false);
        $validated['ingredients'] = collect(preg_split('/\r\n|\r|\n/', $ingredientsText))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
        $validated['steps'] = collect(preg_split('/\r\n|\r|\n/', $stepsText))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        if (empty($validated['content'])) {
            $validated['content'] = implode(PHP_EOL.PHP_EOL, $validated['steps']);
        }

        unset($validated['ingredients_text'], $validated['steps_text']);

        return $validated;
    }
}
