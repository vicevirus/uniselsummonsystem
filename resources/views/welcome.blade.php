<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unisel Summon System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.14/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <!-- Website Logo -->
                    <a href="#" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 dark:text-gray-400 text-lg">Unisel Summon System</span>
                    </a>
                </div>
                <!-- Right side of navbar -->
                <div class="hidden md:flex items-center space-x-3">
                    @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="py-2 px-2 font-medium text-gray-500 dark:text-gray-400 rounded hover:bg-green-500 hover:text-white dark:hover:bg-green-400 transition duration-300">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="py-2 px-2 font-medium text-gray-500 dark:text-gray-400 rounded hover:bg-green-500 hover:text-white dark:hover:bg-green-400 transition duration-300">Log in</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 py-2 px-2 font-medium text-gray-500 dark:text-gray-400 rounded hover:bg-green-500 hover:text-white dark:hover:bg-green-400 transition duration-300">Register</a>
                        @endif
                        @endauth
                    </div>
                    @endif
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class=" w-6 h-6 text-gray-500 dark:text-gray-400 hover:text-green-500 dark:hover:text-green-400" x-show="!showMenu" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu">
            <ul class="">
                <!-- Dynamically add mobile menu items based on auth status -->
                @auth
                <li><a href="{{ url('/dashboard') }}" class="block text-sm px-2 py-4 text-white bg-green-500 font-semibold">Dashboard</a></li>
                @else
                <li><a href="{{ route('login') }}" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Log in</a></li>
                @if (Route::has('register'))
                <li><a href="{{ route('register') }}" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Register</a></li>
                @endif
                @endauth
            </ul>
        </div>
    </nav>

    <div class="hero min-h-screen" style="background-image: url('uniselsummon.webp');">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="flex flex-col items-center justify-center">
                <div class="max-w-md">
                    <h1 class="mb-5 text-5xl font-bold text-white dark:text-gray-300">Welcome to Unisel Summon System</h1>
                </div>
                <div class="card w-96 bg-neutral text-primary-content">
                    <div class="card-body">
                        <p class="text-gray-200 dark:text-gray-400 font-semibold">Effortlessly check, issue, and manage student summons with our intuitive platform. Streamlining processes for universities and students alike.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>

</body>

</html>