@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $user->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input name="username" value="{{ old('username', $user->username ?? '') }}" required class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="mt-1 block w-full rounded border-gray-300" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        @php($role = old('role', $user->role ?? 'viewer'))
        <select name="role" class="mt-1 block w-full rounded border-gray-300">
            <option value="admin" @if($role === 'admin') selected @endif>Admin</option>
            <option value="editor" @if($role === 'editor') selected @endif>Editor</option>
            <option value="viewer" @if($role === 'viewer') selected @endif>Viewer</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" class="mt-1 block w-full rounded border-gray-300" @if(!isset($user)) required @endif />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded border-gray-300" @if(!isset($user)) required @endif />
    </div>
</div>
