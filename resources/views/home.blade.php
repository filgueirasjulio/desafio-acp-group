@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center space-y-6 w-full max-w-4xl">
    <div id="posts-container" class="w-full pt-12"></div>
</div>
@endsection

@auth
    <script src="https://cdn.jsdelivr.net/npm/axios@1.4.0/dist/axios.min.js"></script>
    <script>
        const token = '{{ auth()->user()->createToken('web')->plainTextToken }}';

        axios.get('/api/post', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            const posts = response.data.data; // Obtenha os dados dos posts
            const postsContainer = document.getElementById('posts-container');
            
            // Certifique-se de limpar o container antes de adicionar novos elementos
            postsContainer.innerHTML = '';

            // Adiciona cada post como um card
            posts.forEach(post => {
                const postHtml = `
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('imgs/avatar-default.png') }}" alt="Foto do usuário" class="w-10 h-10 rounded-full">
                        <span class="ml-4 text-gray-700 font-semibold">${post.author.name}</span>
                    </div>
                    <p class="text-gray-600">${post.content}</p>
                    <br>
                    <div class="mt-2">
                        ${post.tags.map(tag => `
                            <span class="inline-block text-xs font-medium text-white px-2 py-1 rounded" style="background-color: ${tag.bg_color}">
                                ${tag.description}
                            </span>`).join(' ')}
                    </div>
                    <div class="text-right mt-4">
                        <small class="text-gray-500">Publicado em ${post.created_at}</small>
                    </div>
                </div>
                `;
                postsContainer.innerHTML += postHtml;
            });
        })
        .catch(error => console.error('Erro ao buscar posts:', error));
    </script>
@endauth
