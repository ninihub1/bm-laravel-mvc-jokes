<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Blony's {{ __('Joke DB') }}
            </h2>
            <div class="flex items-center space-x-4">
                <form method="GET" action="/" class="block">
                    <input type="text" name="keywords" placeholder="Search..."
                           class="w-full md:w-auto py-2 focus:outline-none"/>
                    <button class="w-full md:w-auto
                           bg-red-400 hover:bg-red-600
                           text-white
                           px-4 py-2
                           focus:outline-none transition ease-in-out duration-500">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col flex-wrap my-4 mt-8">
        <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:grid-cols-3 sm:px-8">
            <article class="bg-white shadow rounded p-2 flex flex-col">
                <header class="-mx-2 bg-zinc-700 text-zinc-200 text-lg p-4 -mt-2 mb-4 rounded-t flex-0">
                    <h4>
                        Time for a Random Joke
                    </h4>
                </header>
                <section class="flex-grow flex flex-col space-y-3 text-zinc-600">
                    <p>
                        A cowboy butcher decided to relocate his fresh meat shop.
                    </p>
                    <p>
                        "Sorry Folks. I'm pullin' up steaks."
                    </p>
                </section>
                <footer class="-mx-2 bg-zinc-100 text-zinc-600 text-sm mt-4 -mb-2 rounded-b flex-0">
                    <p class="w-full text-right rounded-b hover:text-black px-4 py-2">
                        Author's Name
                    </p>
                </footer>
            </article>
        </section>
        <section class="flex justify-center mb-6">
            <button class="max-w-96 min-w-64 bg-white shadow rounded p-2 flex flex-col text-center text-xl" onclick="location.reload();">New Joke</button>
        </section>
    </div>
</x-app-layout>
