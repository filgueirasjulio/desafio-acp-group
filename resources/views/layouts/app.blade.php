<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth Page')</title>
    <!-- Carregando o CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full bg-white shadow h-16 flex items-center">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex items-center justify-between h-full">
                    <!-- Logo -->
                    <a href="/dashboard" class="text-xl font-bold text-blue-600">ACPBook</a>
        
                    <!-- Foto e Dropdown -->
                    <div class="relative flex items-center">
                        <!-- Foto do usuário -->
                        <img src="{{asset('/imgs/avatar-default.png')}}" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full border border-gray-200">
        
                        <!-- Setinha -->
                        <button id="dropdown-toggle" 
                        class="absolute bottom-0 right-0 transform translate-x-[0px] translate-y-[10px]">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                fill="#3B82F6" 
                                class="w-6 h-6">
                                <path d="M12 16l-6-6h12z" />
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div id="dropdown-menu" 
                        class="hidden absolute top-12 right-0 bg-white border border-gray-200 shadow-md rounded w-32">
                       <form id="logout-form" action="/logout" method="POST">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.getElementById('dropdown-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');

        dropdownToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden'); 
        });

        document.addEventListener('click', function () {
            dropdownMenu.classList.add('hidden');
        });
    });
</script>
</html>
