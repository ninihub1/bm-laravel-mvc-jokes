<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Blony's {{ __('Deleted Jokes Management') }}
            </h2>
        </div>
    </x-slot>

    <article class="m-12">
        <header
            class="bg-red-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                Deleted Jokes (List)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-trash-alt min-w-8 text-white"></i>
            </div>
        </header>

        @auth
            <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">

                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <thead
                            class="border-b border-neutral-200 bg-red-800 font-medium text-white dark:border-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID</th>
                            <th scope="col" class="px-6 py-4">Joke</th>
                            <th scope="col" class="px-6 py-4">Author</th>
                            <th scope="col" class="px-6 py-4">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($trashedJokes as $joke)
                            <tr class="border-b text-black border-zinc-300 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $joke->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4 w-full">{{ $joke->content }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->user->given_name ?? 'Unknown' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <form action="{{ route('jokes.restore', $joke->id) }}"
                                          method="POST"
                                          class="flex gap-4">
                                        @csrf
                                        @method('PATCH')

                                        <x-primary-button type="submit"
                                                          class="bg-gray-500 text-white">
                                            <span>Restore</span>
                                            <i class="fa-solid fa-recycle pr-2 order-first"></i>
                                        </x-primary-button>
                                    </form>
                                    <form action="{{ route('jokes.force-delete', $joke->id) }}"
                                          method="POST"
                                          class="flex gap-4 mt-2">
                                        @csrf
                                        @method('DELETE')

                                        <x-primary-button type="submit"
                                                          class="bg-red-600 text-white">
                                            <span>Delete Permanently</span>
                                            <i class="fa-solid fa-trash pr-2 order-first"></i>
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-xl py-4">No deleted jokes found</td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="text-black bg-zinc-100">
                            <td colspan="5" class="px-6 py-2">
                                @if( $trashedJokes->hasPages() )
                                    {{ $trashedJokes->links() }}
                                @else
                                    <p class="py-2 text-zinc-800 text-sm">All deleted jokes shown</p>
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
