<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $recipe->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                <p class="text-sm text-gray-600">Slug: {{ $recipe->slug }}</p>
                <p class="text-sm text-gray-600">Status: {{ $recipe->status }}</p>
                <p class="text-sm text-gray-600">Author ID: {{ $recipe->author_id }}</p>
                <p class="text-sm text-gray-600">Image URL: {{ $recipe->image_url }}</p>
                @if($recipe->image_url)
                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->image_alt }}" class="max-h-64 rounded border" />
                @endif
                @if($recipe->excerpt)
                    <p class="italic">{{ $recipe->excerpt }}</p>
                @endif
                <div class="prose max-w-none whitespace-pre-line">{{ $recipe->content }}</div>
                <a href="{{ route('recipes.index') }}" class="text-indigo-600">Back to list</a>
            </div>
        </div>
    </div>
</x-app-layout>
