<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>
        Laravel App
    </title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}" /> --}}
</head>

<body class="w-full h-full bg-gray-100">
    @if (session()->has('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
            class="fixed bg-green-500 py-2 px-4 rounded-full top-3 left-3 text-base sm:text-xl">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session()->has('update-post'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
            class="fixed bg-green-500 py-2 px-4 rounded-full top-3 left-3 text-base sm:text-xl">
            <p>{{ session('update-post') }}</p>
        </div>
    @endif

    <div class="w-4/5 mx-auto">
        <div class="text-center pt-20">
            <h1 class="text-3xl text-gray-700">
                All Articles
            </h1>
            <hr class="border border-1 border-gray-300 mt-10">
        </div>

        <div class="py-10 sm:py-20">
            <a class="primary-btn inline text-base sm:text-xl bg-green-500 py-4 px-4 shadow-xl rounded-full transition-all hover:bg-green-400"
                href="{{ route('blog.create') }}">
                New Article
            </a>
        </div>
    </div>

    @if (session()->has('delete-post'))
        <div class="w-4/5 mx-auto pb-10">
            <div x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Warning
                <div class="border border-t-1 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    {{ session('delete-post') }}
                </div>
            </div>
        </div>
        {{-- <div class="mx-auto w-4/5 pb-10">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Warning
            </div>
            <div class="border border-t-1 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                {{ session()->get('message') }}
            </div>
        </div> --}}
    @endif

    @foreach ($posts as $post)
        <div class="w-4/5 mx-auto pb-10">
            <div class="bg-white pt-10 rounded-lg drop-shadow-2xl sm:basis-3/4 basis-full sm:mr-8 pb-10 sm:pb-0">
                <div class="w-11/12 mx-auto pb-10">
                    <h2 class="text-gray-900 text-2xl font-bold pt-6 pb-0 sm:pt-0 hover:text-gray-700 transition-all">
                        <a href="{{ route('blog.show', $post->id) }}">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="text-gray-900 text-lg py-8 w-full break-words">
                        {{ $post->excerpt }}
                    </p>

                    <span class="text-gray-500 text-sm sm:text-base">
                        Made by:
                        <a href=""
                            class="text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all">
                            {{ $post->user->name }}
                        </a>
                        on {{ $post->updated_at->format('d/m/Y') }}
                    </span>

                    <a href="{{ route('blog.edit', $post->id) }}"
                        class="block italic text-green-500 border-b-1 border-green-400">
                        Edit
                    </a>

                    <form action="{{ route('blog.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="pt-3 text-red-500 pr-3">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mx-auto pb-10 w-4/5">
        {{ $posts->onEachSide(1)->links() }}
    </div>
</body>

</html>
