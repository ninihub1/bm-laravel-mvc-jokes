<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Roles and Permissions') }}
        </h2>
    </x-slot>

    <article class="m-12">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">Roles and Users</h2>
        </header>

        <div class="mt-6">
            <!-- Display All Roles -->
            <section>
                <h3 class="text-lg font-semibold">Assign Role to User</h3>
                <form action="{{ route('roles-permissions.assign') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="user_id" class="block text-sm font-medium">Select User</label>
                            <select name="user_id" id="user_id" class="form-select w-full">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nickname }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="role_id" class="block text-sm font-medium">Select Role</label>
                            <select name="role_id" id="role_id" class="form-select w-full">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-primary-button type="submit">Assign Role</x-primary-button>
                    </div>
                </form>
            </section>

            <!-- Display Users and Their Roles -->
            <section class="mt-12">
                <h3 class="text-lg font-semibold">Users and Roles</h3>
                <table class="min-w-full mt-4 border border-zinc-300">
                    <thead class="bg-zinc-800 text-white">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Roles</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-zinc-300">
                                <td class="px-6 py-4">{{ $user->given_name. ' '. $user->family_name}}</td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="text-xs text-black bg-zinc-500 px-2 rounded-full inline-block">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <form action="{{ route('roles-permissions.revoke') }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <x-secondary-button type="submit" class="bg-red-600 text-black">
                                                Remove {{ $role->name }}
                                            </x-secondary-button>
                                        </form>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </article>
</x-app-layout>
