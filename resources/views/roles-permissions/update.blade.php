<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Blony's {{ __('Permission Management') }}
        </h2>
    </x-slot>

    <article class="m-12">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                Edit Permission
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-key min-w-8 text-white"></i>
            </div>
            <x-primary-link-button href="{{ route('roles-permissions.index') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-list-ul"></i>
                <span class="pl-4">View Permissions</span>
            </x-primary-link-button>
        </header>

        @auth
            <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col flex-wrap m-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">
                    <form action="{{ route('roles-permissions.update', $permission->id) }}" method="POST" class="flex gap-4">

                        @csrf
                        @method('PUT')

                        <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <header class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                    Update permission details
                                </p>
                            </header>

                            <section class="py-4 px-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">

                                <div class="flex flex-col my-2">
                                    <x-input-label for="name">
                                        Permission Name
                                    </x-input-label>
                                    <x-text-input id="name" name="name" value="{{ old('name', $permission->name) }}"/>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                </div>

                            </section>

                            <footer class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                <x-primary-link-button href="{{ route('roles-permissions.index') }}" class="bg-zinc-800">
                                    Cancel
                                </x-primary-link-button>

                                <x-primary-button type="submit" class="bg-zinc-800">
                                    Update Permission
                                </x-primary-button>
                            </footer>
                        </div>
                    </form>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>
