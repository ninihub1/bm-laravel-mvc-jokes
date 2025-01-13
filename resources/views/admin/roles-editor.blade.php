<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles and Permissions Management') }}
        </h2>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Roles and Permissions</h3>
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Role</th>
                                <th class="border border-gray-300 px-4 py-2">Permissions</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $role->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @foreach ($role->permissions as $permission)
                                            <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <form method="POST" action="{{ route('admin.assign-permissions') }}" class="inline">
                                            @csrf
                                            <select name="permission" class="border rounded">
                                                <option value="">SELECT PERMISSION TO ASSIGN</option>
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <x-primary-button>{{ __('Assign Permission') }}</x-primary-button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.revoke-permissions') }}" class="inline">
                                            @csrf
                                            <select name="permission" class="border rounded">
                                                <option value="">SELECT PERMISSION TO REVOKE</option>
                                                @foreach ($role->permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <x-primary-button>{{ __('Revoke Permission') }}</x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3 class="text-lg font-bold mt-8 mb-4">Assign Role to User</h3>
                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="flex space-x-4">
                            <select name="user" class="border rounded w-1/2">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->given_name }}</option>
                                @endforeach
                            </select>
                            <select name="role" class="border rounded w-1/2">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-primary-button>{{ __('Assign Role') }}</x-primary-button>
                        </div>
                    </form>

                    <!-- Remove Role from User -->
                    <h3 class="text-lg font-bold mt-8 mb-4">Remove Role from User</h3>
                    <form method="POST" action="{{ route('admin.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="flex space-x-4">
                            <select name="user_id" class="border rounded w-1/2">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->given_name .' '. $user->family_name }}</option>
                                @endforeach
                            </select>
                            <select name="role" class="border rounded w-1/2">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-primary-button>{{ __('Remove Role') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
