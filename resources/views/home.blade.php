<x-layouts.main-app>

    <section class="flex min-h-[70vh] flex-col items-center justify-center bg-white px-4 pb-12 dark:bg-gray-950">
        <div class="w-full max-w-xl text-center">
            <x-lottie-animation id="hero-animation" src="{{ asset('lotties/hero-animation.lottie') }}" class="size-72"/>
            <h1 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Find the Right Internship for
                Your Future</h1>
            <p class="mb-6 text-lg text-gray-600 dark:text-gray-300">Explore curated internship opportunities tailored
                for vocational students.</p>
            <a href="{{ route('internships.index') }}"
               class="inline-block rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white shadow transition hover:bg-blue-700">I'm
                Ready!</a>
        </div>
    </section>

    <section class="bg-gray-50 px-4 py-16 dark:bg-gray-900">
        <div class="mx-auto max-w-5xl">
            <h2 class="mb-8 text-center text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">Why Choose SKI
                MAGANG?</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="flex flex-col items-center rounded-xl bg-white p-6 text-center shadow dark:bg-gray-800">
                    <flux:icon name="bookmark" class="mb-4 h-12 w-12 text-blue-600"/>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Curated Opportunities</h3>
                    <p class="text-gray-600 dark:text-gray-300">All internships are selected and updated for vocational
                        students, ensuring relevance and quality.</p>
                </div>
                <div class="flex flex-col items-center rounded-xl bg-white p-6 text-center shadow dark:bg-gray-800">
                    <flux:icon name="heart" class="mb-4 h-12 w-12 text-pink-500"/>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Bookmark & Like</h3>
                    <p class="text-gray-600 dark:text-gray-300">Easily bookmark and like internships to keep track of
                        your favorites and never miss an opportunity.</p>
                </div>
                <div class="flex flex-col items-center rounded-xl bg-white p-6 text-center shadow dark:bg-gray-800">
                    <flux:icon name="bolt" class="mb-4 h-12 w-12 text-yellow-500"/>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Fast & Easy Access</h3>
                    <p class="text-gray-600 dark:text-gray-300">Quickly discover, search, and apply for internships with
                        a user-friendly interface designed for students.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.main-app>
