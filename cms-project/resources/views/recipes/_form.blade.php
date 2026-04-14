@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input name="title" value="{{ old('title', $recipe->title ?? '') }}" required class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Slug</label>
        <input name="slug" value="{{ old('slug', $recipe->slug ?? '') }}" required class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('description', $recipe->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Image URL</label>
        <input name="image_url" value="{{ old('image_url', $recipe->image_url ?? '') }}" placeholder="/images/adobo.png" class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Image Alt</label>
        <input name="image_alt" value="{{ old('image_alt', $recipe->image_alt ?? '') }}" class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Prep Minutes</label>
            <input type="number" min="0" name="prep_mins" value="{{ old('prep_mins', $recipe->prep_mins ?? 0) }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Cook Minutes</label>
            <input type="number" min="0" name="cook_mins" value="{{ old('cook_mins', $recipe->cook_mins ?? 0) }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Difficulty</label>
            @php($difficulty = old('difficulty', $recipe->difficulty ?? 'Easy'))
            <select name="difficulty" class="mt-1 block w-full rounded border-gray-300">
                <option value="Easy" @if($difficulty === 'Easy') selected @endif>Easy</option>
                <option value="Medium" @if($difficulty === 'Medium') selected @endif>Medium</option>
                <option value="Hard" @if($difficulty === 'Hard') selected @endif>Hard</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Featured</label>
            @php($featured = old('featured', isset($recipe) ? (int) $recipe->featured : 0))
            <select name="featured" class="mt-1 block w-full rounded border-gray-300">
                <option value="0" @if((string)$featured === '0') selected @endif>No</option>
                <option value="1" @if((string)$featured === '1') selected @endif>Yes</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Rating</label>
            <input type="number" min="0" max="5" step="0.1" name="rating" value="{{ old('rating', $recipe->rating ?? 0) }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Rating Count</label>
            <input type="number" min="0" name="rating_count" value="{{ old('rating_count', $recipe->rating_count ?? 0) }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Region</label>
            <input name="region" value="{{ old('region', $recipe->region ?? '') }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Course</label>
            <input name="course" value="{{ old('course', $recipe->course ?? '') }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Main Ingredient</label>
            <input name="main_ingredient" value="{{ old('main_ingredient', $recipe->main_ingredient ?? '') }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Ingredients (one per line)</label>
        <textarea name="ingredients_text" rows="6" class="mt-1 block w-full rounded border-gray-300">{{ old('ingredients_text', isset($recipe) ? implode(PHP_EOL, $recipe->ingredients ?? []) : '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Steps (one per line)</label>
        <textarea name="steps_text" rows="8" class="mt-1 block w-full rounded border-gray-300">{{ old('steps_text', isset($recipe) ? implode(PHP_EOL, $recipe->steps ?? []) : '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Excerpt</label>
        <textarea name="excerpt" rows="2" class="mt-1 block w-full rounded border-gray-300">{{ old('excerpt', $recipe->excerpt ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Content</label>
        <textarea name="content" rows="10" required class="mt-1 block w-full rounded border-gray-300">{{ old('content', $recipe->content ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full rounded border-gray-300">
            @php($selected = old('status', $recipe->status ?? 'draft'))
            <option value="draft" @if($selected === 'draft') selected @endif>Draft</option>
            <option value="published" @if($selected === 'published') selected @endif>Published</option>
        </select>
    </div>
</div>
