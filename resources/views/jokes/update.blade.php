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
                Edit Joke
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-laugh-squint min-w-8 text-white"></i>
            </div>
            <x-primary-link-button href="{{ route('jokes.create') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-plus-circle"></i>
                <span class="pl-4">Add Joke</span>
            </x-primary-link-button>
        </header>

        @auth
        <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">
                    <form action="{{ route('jokes.update', $joke->id) }}"
                          method="POST"
                          class="flex gap-4">

                        @csrf
                        @method('PUT')

                        <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <header
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                    Update the Joke Details
                                </p>
                            </header>

                            <section
                                class="py-4 px-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">

                                <div class="flex flex-col my-2">
                                    <x-input-label for="title">
                                        Title
                                    </x-input-label>
                                    <x-text-input id="title" name="title" value="{{ $joke->title }}"/>
                                    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="category">
                                        Category
                                    </x-input-label>
                                    <x-text-input id="category" name="category" value="{{ $joke->category }}"/>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="tags">
                                        Tags
                                    </x-input-label>
                                    <x-text-input id="tags" name="tags" value="{{ $joke->tags }}"/>
                                    <x-input-error :messages="$errors->get('tags')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="content">
                                        Content
                                    </x-input-label>
                                    <x-text-input id="content" name="content" value="{{ $joke->content }}"/>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                                </div>

                                <footer
                                    class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                    <x-primary-link-button href="{{ route('jokes.index') }}" class="bg-zinc-800">
                                        Cancel
                                    </x-primary-link-button>

                                    <x-primary-button type="submit" class="bg-zinc-800">
                                        Save Changes
                                    </x-primary-button>
                                </footer>
                            </section>
                        </div>
                    </form>
                </section>
            </section>
        </div>

    </article>
</x-app-layout>
