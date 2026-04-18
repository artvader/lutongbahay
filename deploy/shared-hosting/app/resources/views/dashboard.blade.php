<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CMS Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Recipes</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalRecipes }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Published</p>
                    <p class="mt-2 text-2xl font-semibold text-green-700">{{ $publishedRecipes }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Drafts</p>
                    <p class="mt-2 text-2xl font-semibold text-amber-700">{{ $draftRecipes }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Recipes</h3>
                    <a href="{{ route('recipes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">New Recipe</a>
                </div>
                <div class="p-6">
                    @forelse($recentRecipes as $recipe)
                        <div class="py-2 flex items-center justify-between border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $recipe->title }}</p>
                                <p class="text-sm text-gray-500">{{ $recipe->status }} · {{ $recipe->slug }}</p>
                            </div>
                            <a href="{{ route('recipes.edit', $recipe) }}" class="text-indigo-600">Edit</a>
                        </div>
                    @empty
                        <p class="text-gray-600">No recipes yet. Create your first recipe.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
