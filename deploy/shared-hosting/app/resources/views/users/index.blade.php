<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Access Control</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <a href="{{ route('users.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded">Create User</a>

            <div class="bg-white shadow sm:rounded-lg divide-y">
                @foreach($users as $user)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <p class="font-semibold">{{ $user->name }} ({{ $user->username }})</p>
                            <p class="text-sm text-gray-600">{{ $user->email }} · role: {{ $user->role }}</p>
                        </div>
                        <div class="space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600">Edit</a>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
