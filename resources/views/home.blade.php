@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center space-y-6 w-full max-w-4xl">
    <label class="switch absolute">
        <input type="checkbox" id="toggle-posts">
        <span class="slider round"></span>
    </label>
    <div id="posts-container" class="w-full pt-8"></div>

    @auth
        <script src="https://cdn.jsdelivr.net/npm/axios@1.4.0/dist/axios.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePosts = document.getElementById('toggle-posts');
                const postsContainer = document.getElementById('posts-container');
                const token = '{{ auth()->user()->createToken('web')->plainTextToken }}';
                const userId = {{ auth()->user()->id }};

                // Buscar todos os posts inicialmente
                buscarPosts(false);

                togglePosts.addEventListener('change', async () => {
                    const showOnlyUserPosts = togglePosts.checked;
                    buscarPosts(showOnlyUserPosts);
                });

                async function buscarPosts(showOnlyUserPosts) {
                    try {
                        const response = await axios.get('/api/post', {
                            headers: {
                                'Authorization': `Bearer ${token}`,
                            },
                            params: {
                                user_id: showOnlyUserPosts ? userId : null,
                            },
                        });

                        const posts = response.data.data;
                        postsContainer.innerHTML = '';

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
                    } catch (error) {
                        console.error('Erro ao buscar posts:', error);
                    }
                }
            });
        </script>
    @endauth
@endsection