<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth Page')</title>
    <!-- Carregando o CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/auth.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full bg-white shadow h-16 flex items-center">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex items-center justify-start h-full">
                    <a href="/" class="text-xl font-bold text-blue-600">ACPBook</a>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-12">
            @yield('content')  <!-- Este conteúdo precisa ser correto na página que está sendo renderizada -->
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-4 bg-gray-200">
            <p class="text-sm text-gray-600">&copy; {{ date('Y') }} ACPbook. Todos os direitos reservados.</p>
        </footer>
</body>
</html>
