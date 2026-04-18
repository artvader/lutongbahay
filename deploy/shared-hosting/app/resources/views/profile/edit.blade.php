<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input name="username" value="{{ old('username', $user->username) }}" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Profile</button>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Update Password</h3>
                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full rounded border-gray-300" />
                    </div>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
