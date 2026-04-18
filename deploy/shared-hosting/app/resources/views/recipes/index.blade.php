<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Recipes CMS</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <a href="{{ route('recipes.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded">New Recipe</a>

            <div class="bg-white shadow sm:rounded-lg divide-y">
                @forelse ($recipes as $recipe)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <p class="font-semibold">{{ $recipe->title }}</p>
                            <p class="text-sm text-gray-600">{{ $recipe->slug }} | {{ $recipe->status }}</p>
                        </div>
                        <div class="space-x-2">
                            <a href="{{ route('recipes.show', $recipe) }}" class="text-indigo-600">View</a>
                            <a href="{{ route('recipes.edit', $recipe) }}" class="text-indigo-600">Edit</a>
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete recipe?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-600">No recipes found.</p>
                @endforelse
            </div>

            {{ $recipes->links() }}
        </div>
    </div>
</x-app-layout>
