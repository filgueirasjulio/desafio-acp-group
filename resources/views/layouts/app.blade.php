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
        <header class="w-full bg-white shadow h-16 flex items-center fixed top-0 left-0 z-50">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex items-center justify-between h-full space-x-4">
                    <!-- Logo -->
                    <a href="/" class="text-xl font-bold text-blue-600">ACPBook</a>
            
                    <!-- Foto e Dropdown -->
                    <div class="flex items-center space-x-4 relative">
                        <!-- Foto do usuário -->
                        <img src="{{asset('/imgs/avatar-default.png')}}" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full border border-gray-200">
            
                        <!-- Nome do usuário -->
                        <span class="text-gray-700">{{ auth()->user()->name }}</span>
            
                        <!-- Ícone de três pontos (cubos mágicos) -->
                        <button id="dropdown-toggle" 
                            class="ml-3 bg-gray-800 text-white p-2 rounded-full hover:bg-gray-700 focus:outline-none flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                class="w-4 h-4">
                                <circle cx="6" cy="12" r="1.5"></circle>
                                <circle cx="12" cy="12" r="1.5"></circle>
                                <circle cx="18" cy="12" r="1.5"></circle>
                            </svg>
                        </button>
            
                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu" 
                             class="absolute top-12 right-0 bg-white border border-gray-200 shadow-md rounded w-32"
                             style="display: none;">
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
            
            <script>
                const dropdownMenu = document.getElementById('dropdown-menu');
                const toggleMenu = () => {
                dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
                };

                document.getElementById('dropdown-toggle').addEventListener('click', toggleMenu);

                document.addEventListener('click', function(event) {
                if (!event.target.closest('#dropdown-toggle') && !event.target.closest('#dropdown-menu')) {
                    dropdownMenu.style.display = 'none';
                }
                });
            </script>
            
                       
        </header>
        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-12">
            @yield('content')  
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-4 bg-gray-200">
            <p class="text-sm text-gray-600">&copy; {{ date('Y') }} ACPbook. Todos os direitos reservados.</p>
        </footer>
 
        
        <script>
            // Captura o clique do botão de três pontos para mostrar/ocultar o menu
            document.getElementById('dropdown-toggle').addEventListener('click', function(event) {
            console.log('Clique no botão');

            const dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('hidden');
            })

            // Fecha o menu quando clicar fora do botão ou do próprio menu
            document.addEventListener('click', function(event) {
                const dropdownMenu = document.getElementById('dropdown-menu');
                if (!event.target.closest('#dropdown-toggle') && !event.target.closest('#dropdown-menu')) {
                    dropdownMenu.classList.add('hidden');  // Fecha o menu
                }
            });
        </script>
</body>
</html>
