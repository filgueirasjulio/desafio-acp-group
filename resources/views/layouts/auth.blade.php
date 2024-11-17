<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth Page')</title>
    <!-- Carregando o CSS -->
    @vite('resources/css/app.css')
    @vite('resources/css/auth.css')
</head>
<body>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <header class="w-full bg-white shadow h-16 flex items-center">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex items-center justify-start h-full">
                    <a href="/" class="text-xl font-bold text-blue-600">ACPBook</a>
                </div>
            </nav>
        </header>

        <main class="flex items-center justify-center w-full mt-6">
            <!-- Container para o Vue -->
            <div id="app">
                @yield('content')
            </div>
        </main>

        <footer class="mt-auto w-full text-center py-4 bg-gray-200">
            <p class="text-sm text-gray-600">&copy; {{ date('Y') }} ACPbook. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
@vite('resources/js/app.js')
</html>
