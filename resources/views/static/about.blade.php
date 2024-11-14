<x-app-layout>

    <article class="flex flex-col gap-8">
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

        <section class="container mx-auto border grow h-full shadow-md p-4 pb-8 rounded space-y-2">
            <h2 class="text-2xl text-zinc-50 bg-zinc-700 p-4 pb-6 mb-6 -mx-4 -mt-4 rounded-t">
                The Team
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                <section class="border border-2 p-2 text-zinc-500 space-y-2">
                    <header class="-mt-2 -mx-2 mb-4 flex space-x-2 bg-zinc-700 text-zinc-100  items-center">
                        <h4 class="p-2 py-3 text-2xl font-medium w-2/3">
                            Blony Maunela
                        </h4>
                        <p class="px-2 text-sm text-right grow">
                            Lead Developer
                        </p>
                    </header>

                    <p>Developer Diploma Student</p>

                </section>

                <section class="border-2 p-2 text-zinc-500 space-y-2">
                    <header class="-mt-2 -mx-2 mb-4 flex space-x-2 bg-zinc-700 text-zinc-100  items-center">
                        <h4 class="p-2 py-3 text-2xl font-medium w-2/3">
                            Project Overview
                        </h4>
                        <p class="px-2 text-sm text-right grow">
                            Jokes
                        </p>
                    </header>

                    <p>
                        This website is built using the Laravel framework, providing a robust and scalable platform for users to enjoy humor.
                        It allows users to:
                    </p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Add their own jokes to the database, contributing to a growing collection of humor.</li>
                        <li>Browse through a curated list of jokes submitted by other users.</li>
                        <li>Get random jokes at the click of a button, ensuring a fresh dose of laughter every time.</li>
                        <li>Search for specific jokes using keywords, making it easy to find favorites.</li>
                    </ul>
                    <p>
                        Whether you're looking for a quick laugh or want to share your own comedic genius, this platform is designed to bring joy and entertainment to everyone.
                        Join us in building a vibrant community of joke lovers!
                    </p>
                </section>

                <section class="border border-2 p-2 text-zinc-500 space-y-2">
                    <header class="-mt-2 -mx-2 mb-4 flex space-x-2 bg-zinc-700 text-zinc-100  items-center">
                        <h4 class="p-2 py-3 text-2xl font-medium w-2/3">
                            Adrian Gould
                        </h4>
                        <p class="px-2 text-sm text-right grow">
                            Development Supervisor
                        </p>
                    </header>

                    <p>Lecturer</p>

                </section>


            </div>
        </section>

        <section class="container mx-auto border grow h-full shadow-md p-4 pb-8 rounded space-y-2">
            <h2 class="text-2xl text-zinc-50 bg-zinc-700 p-4 pb-6 mb-6 -mx-4 -mt-4 rounded-t">
                Technologies
            </h2>

            <div class=" flex-col grid grid-cols-1 lg:grid-cols-2 gap-6 text-zinc-600">
                <p>
                    <a href="#" class="hover:text-zinc-500 underline underline-offset-4">
                        <i class="fa-brands fa-php pr-1"></i>
                        PHP
                    </a>
                </p>
                <p>
                    <a href="#" class="hover:text-zinc-500 underline underline-offset-4">
                        <i class="fa-brands fa-laravel pr-1"></i>
                        Laravel
                    </a>
                </p>
                <p>
                    <a href="#" class="hover:text-zinc-500 underline underline-offset-4">
                        <i class="fa-brands fa-css3 pr-1"></i>
                        TailwindCSS
                    </a>
                </p>
                <p>
                    <a href="#" class="hover:text-zinc-500 underline underline-offset-4">
                        <i class="fa-brands fa-font-awesome pr-1"></i>
                        FontAwesome
                    </a>
                </p>
            </div>
        </section>

        <section class="container mx-auto grow h-full p-4 pb-8
                            border border-zinc-400
                            shadow-md rounded space-y-2
                            bg-zinc-200  text-zinc-800">
            <header class="-mx-4 bg-zinc-700 text-zinc-200 text-md text-semibold p-4 -mt-4 mb-4 rounded-t flex-0">
                <h4 class="text-2xl">
                    Useful References
                </h4>
            </header>
            <dl class="grid grid-cols-5 gap-2 p-4">

                <dt class="col-span-1">HelpDesk</dt>
                <dd class="col-span-4">
                    <a href="https://help.screencraft.net.au"
                       class="underline underline-offset-2 text-zinc-900 rounded border-2 border-transparent hover:text-zinc-500 ">
                        https://help.screencraft.net.au
                    </a>
                </dd>

                <dt class="col-span-1">HelpDesk FAQs</dt>
                <dd class="col-span-4">
                    <a href="https://help.screencraft.net.au/hc/2680392001"
                       class="underline underline-offset-2 text-zinc-900 rounded border-2 border-transparent hover:text-zinc-500 ">
                        https://help.screencraft.net.au/hc/2680392001
                    </a>
                </dd>

                <dt class="col-span-1">Make a Request</dt>
                <dd class="col-span-4">
                    <a href="https://help.screencraft.net.au/help/2680392001"
                       class="underline underline-offset-2 text-zinc-900 rounded border-2 border-transparent hover:text-zinc-500 ">
                        https://help.screencraft.net.au/help/2680392001</a>
                    (TAFE Students only)
                </dd>
            </dl>

        </section>

    </article>
</x-app-layout>
