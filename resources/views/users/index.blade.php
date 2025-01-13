<x-app-layout>

     <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Blony's {{ __('Joke DB') }}
            </h2>
        </div>
    </x-slot>


    <article class="m-12">
        <header
            class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                Users (List)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-user min-w-8 text-white"></i>
            </div>
            <x-primary-link-button href="{{route ('users.create')}}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-user-plus "></i>
                <span class="pl-4">Add User</span>
            </x-primary-link-button>
        </header>
        @auth
            <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col sm:flex-row gap-4 mt-4">
            <form action="{{ route('users.index') }}" method="GET" class="flex gap-4 w-full">
                <input type="text" name="keyword" value="{{ request()->keyword }}" placeholder="Search Users"
                       class="px-4 py-2 border border-zinc-300 rounded-md flex-1">
                <button type="submit" class="px-4 py-2 bg-zinc-800 text-white rounded-md hover:bg-zinc-600">Search</button>
            </form>
        </div>

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">

                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <thead
                            class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID</th>
                            <th scope="col" class="px-6 py-4">Name</th>
                            <th scope="col" class="px-6 py-4">Email</th>
                            <th scope="col" class="px-6 py-4">Role</th>
                            <th scope="col" class="px-6 py-4">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr class="border-b text-black border-zinc-300 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $user->id}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $user->given_name . ' ' . $user->family_name}}</td>
                                <td class="whitespace-nowrap px-6 py-4 w-full">{{ $user->email}}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <span class="text-xs text-white bg-zinc-500 px-2 rounded-full inline-block">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-white bg-zinc-500 px-2 rounded-full inline-block">Guest</span>
                                    @endif
                                </td>

                                 <td class="whitespace-nowrap px-6 py-4">
                                    <form action="{{ route('users.destroy', $user) }}"
                                          method="POST"
                                          class="flex gap-4">
                                        @csrf
                                        @method('DELETE')

                                        <x-primary-link-button href="{{ route('users.show', $user) }}"
                                                               class="bg-zinc-800">
                                            <span>Show </span>
                                            <i class="fa-solid fa-eye pr-2 order-first"></i>
                                        </x-primary-link-button>
                                        <x-primary-link-button href="{{ route('users.edit', $user) }}"
                                                               class="bg-zinc-800">
                                            <span>Edit </span>
                                            <i class="fa-solid fa-edit pr-2 order-first"></i>
                                        </x-primary-link-button>
                                        <x-secondary-button type="submit"
                                                            class="bg-zinc-200">
                                            <span>Delete</span>
                                            <i class="fa-solid fa-times pr-2 order-first"></i>
                                        </x-secondary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                         <tr class="text-black bg-zinc-100">
                            <td colspan="5" class="px-6 py-2">
                                @if( $users->hasPages() )
                                    {{ $users->links() }}
                                @elseif( $users->total() === 0 )
                                    <p class="text-xl">No users found</p>
                                @else
                                    <p class="py-2 text-zinc-800 text-sm">All users shown</p>
                                @endif
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>

