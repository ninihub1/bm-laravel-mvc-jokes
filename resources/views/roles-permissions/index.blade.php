<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Permissions Management') }}
            </h2>
            <!-- Add New Permission Button -->
            <x-primary-link-button href="{{ route('roles-permissions.create') }}" class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-plus-circle"></i>
                <span class="pl-4">Create New Permission</span>
            </x-primary-link-button>
        </div>
    </x-slot>

    @auth
        <x-flash-message :data="session()"/>
    @endauth

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Permissions List</h3>

                    <!-- Permissions Table -->
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Permission Name</th>
                                <th class="border border-gray-300 px-4 py-2">Guard Name</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $permission->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $permission->guard_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <!-- Edit Button -->
                                        <x-primary-link-button href="{{ route('roles-permissions.edit', $permission->id) }}" class="bg-zinc-800 text-white hover:bg-zinc-900">
                                            <i class="fa-solid fa-edit pr-2 order-first"></i>
                                            <span>Edit</span>
                                        </x-primary-link-button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('roles-permissions.destroy', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-secondary-button type="submit" class="bg-gray-600 hover:bg-red-700 text-white">
                                                <i class="fa-solid fa-times pr-2 order-first"></i>
                                                <span>Delete</span>
                                            </x-secondary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
