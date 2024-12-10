<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Blony's {{ __('Joke DB') }}
            </h2>
        </div>
    </x-slot>

    <article class="m-12">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                Joke Details
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-laugh-squint min-w-8 text-white"></i>
            </div>
        </header>

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">

                    <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <header class="grid grid-cols-2 border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <p class="px-6 py-4 text-2xl">Item</p>
                            <p class="px-6 py-4 text-2xl">Content</p>
                        </header>

                        <section class="grid grid-cols-2 border border-neutral-300 bg-gray-200 font-medium text-zinc-800 dark:border-white/10">

                            <p class="bg-gray-300 whitespace-nowrap px-6 py-4 border-r border-b border-neutral-400 dark:border-white/10">Title</p>
                            <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">{{$joke->title}}</p>

                            <p class="bg-gray-300 whitespace-nowrap px-6 py-4 border-r border-b border-neutral-400 dark:border-white/10">Content</p>
                            <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">{{$joke->content}}</p>

                            <p class="bg-gray-300 whitespace-nowrap px-6 py-4 border-r border-b border-neutral-400 dark:border-white/10">Category</p>
                            <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">{{$joke->category->name}}</p>

                            <p class="bg-gray-300 whitespace-nowrap px-6 py-4 border-r border-b border-neutral-400 dark:border-white/10">Tags</p>
                            <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">{{$joke->tags}}</p>

                            <p class="bg-gray-300 whitespace-nowrap px-6 py-4 border-r border-b border-neutral-400 dark:border-white/10">Author</p>
                            @if ($joke->user)
                                <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">
                                    {{$joke->user->given_name . " ". $joke->user->family_name}}
                                </p>
                            @else
                                <p class="whitespace-nowrap px-6 py-4 border-b border-neutral-400 dark:border-white/10">
                                    Author not found
                                </p>
                            @endif
                        </section>

                        <footer class="grid grid-cols-1 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">
                            <form action="" method="POST" class="flex gap-4">
                                @csrf

                                <x-primary-link-button href="{{ route('jokes.index') }}" class="bg-zinc-800">
                                    Back
                                </x-primary-link-button>

                                <x-primary-link-button href="{{ route('jokes.edit', $joke->id) }}" class="bg-zinc-800">
                                    Edit
                                </x-primary-link-button>
                            </form>
                        </footer>
                    </div>

                </section>

            </section>
        </div>
    </article>

</x-app-layout>
