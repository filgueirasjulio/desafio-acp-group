@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center space-y-6 w-full mt-4 max-w-4xl">


        <label class="switch absolute">
            <input type="checkbox" id="toggle-posts">
            <span class="slider round"></span>
        </label>

        <div class="bg-white shadow-md rounded-lg p-4 mb-4 w-full mt-16">
            <div class="flex items-center mb-4">
                <img src="{{ asset('imgs/avatar-default.png') }}" alt="Foto do usuário" class="w-10 h-10 rounded-full">
                <span class="ml-4 text-gray-700 font-semibold">{{ auth()->user()->name }}</span>
            </div>
            <textarea name="content" id="post-content" rows="3"
                class="w-full p-2 rounded-lg border border-gray-200 focus:outline-none focus:ring focus:ring-gray-300 resize-none"
                placeholder="Escreva sua mensagem...">
            </textarea>
            <div id="tag-suggestions" class="w-full mt-2"></div>
            <button id="post-submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                Publicar
            </button>
        </div>

        <div id="posts-container" class="w-full pt-8"></div>

        @auth
            <script src="https://cdn.jsdelivr.net/npm/axios@1.4.0/dist/axios.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const togglePosts = document.getElementById('toggle-posts');
                    const postsContainer = document.getElementById('posts-container');
                    const contentInput = document.getElementById('post-content');
                    const publishButton = document.getElementById('post-submit');
                    const token = '{{ auth()->user()->createToken('web')->plainTextToken }}';
                    const userId = {{ auth()->user()->id }};

                    //função auxiliar para formatação de datas
                    function formatDate(dateString) {
                        const date = new Date(dateString);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // Janeiro é 0, por isso somamos 1
                        const year = date.getFullYear();
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const seconds = String(date.getSeconds()).padStart(2, '0');

                        return `${day}/${month}/${year}, ${hours}:${minutes}:${seconds}`;
                    }

                    // Carregar todos os posts inicialmente
                    buscarPosts(false);

                    togglePosts.addEventListener('change', () => {
                        const showOnlyUserPosts = togglePosts.checked;
                        buscarPosts(showOnlyUserPosts);
                    });

                    // Função para buscar posts
                    async function buscarPosts(showOnlyUserPosts) {
                        try {
                            const response = await axios.get('/api/post', {
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                },
                                params: {
                                    user_id: showOnlyUserPosts ? userId : null
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
                                        <div class="flex justify-between mt-5">
                                            <div class="tags">
                                                ${post.tags.map(tag => `
                                                                <span class="inline-block text-xs font-medium text-white px-2 py-1 rounded" style="background-color: ${tag.bg_color}">
                                                                    ${tag.description}
                                                                </span>`).join(' ')}
                                            </div>
                                            <div class="text-right">
                                                <small class="text-gray-500">Publicado em ${formatDate(post.created_at)}</small>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                postsContainer.innerHTML += postHtml;
                            });


                        } catch (error) {
                            console.error('Erro ao buscar posts:', error);
                        }
                    }

                    // Função para buscar tags
                    function fetchTags(description) {
                        return axios.get(`/api/tag?description=${description}`, {
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                }
                            })
                            .then(response => {
                                return response.data.data || [];
                            })
                            .catch(error => {
                                console.warn(`Nenhuma tag encontrada para "${description}" ou erro na requisição.`,
                                    error);
                                return [];
                            });
                    }

                    // Função para analisar conteúdo e obter tags
                    function analyzeContent(content) {
                        const words = content.split(/\s+/);
                        const tagsPromises = [];
                        const selectedTags = new Set();

                        // Envia as palavras para a função fetchTags
                        words.forEach(word => {
                            if (word.length >= 3) {
                                tagsPromises.push(fetchTags(word));
                            }
                        });

                        // Aguarda todas as requisições de tags serem completadas
                        Promise.all(tagsPromises)
                            .then(responses => {
                                // Processa as respostas de todas as promessas
                                responses.forEach(tagsData => {
                                    if (Array.isArray(tagsData)) {
                                        tagsData.forEach(tag => selectedTags.add(tag
                                            .id)); // Adiciona as tags ao Set
                                    }
                                });

                                const finalSelectedTags = Array.from(selectedTags); // Converte o Set para um array
                                createPost(content, finalSelectedTags); // Cria o post com as tags selecionadas
                            })
                            .catch(error => {
                                createPost(content, []);
                            });
                    }

                    // Função para criar um post
                    function createPost(content, selectedTags) {
                        axios.post('/api/post/store', {
                                content: content,
                                user_id: userId,
                                tags: selectedTags
                            }, {
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                }
                            })
                            .then(response => {
                                const newPost = response.data;
                                addPostToPage(newPost); // Envia o post direto ao HTML
                            })
                            .catch(error => {
                                console.error('Erro ao publicar o post:', error);
                            });
                    }

                    // Adiciona o post à página
                    function addPostToPage(post) {  
                        const postHtml = `
                        <div class="bg-white shadow-md rounded-lg p-4 mb-4 new-post">
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('imgs/avatar-default.png') }}" alt="Foto do usuário" class="w-10 h-10 rounded-full">
                                <span class="ml-4 text-gray-700 font-semibold">${post.data.author.name}</span>
                            </div>
                            <p class="text-gray-600">${post.data.content}</p>
                            <div class="flex justify-between mt-5">
                                <div class="tags">
                                    ${post.data.tags.map(tag => `
                                                    <span class="inline-block text-xs font-medium text-white px-2 py-1 rounded" style="background-color: ${tag.bg_color}">
                                                        ${tag.description}
                                                    </span>`).join(' ')}
                                </div>
                                <div class="text-right">
                                    <small class="text-gray-500">Publicado em ${formatDate(post.data.created_at)}</small>
                                </div>
                            </div>
                        </div>
                    `;

                        postsContainer.insertAdjacentHTML('afterbegin', postHtml);

                        // Após a inserção, ativar a classe para animação
                        const newPostElement = postsContainer.querySelector('.new-post');
                        setTimeout(() => {
                            newPostElement.classList.add('visible');
                        }, 10); // Pequeno atraso para garantir que o navegador registre a mudança

                        contentInput.value = ''; // Limpa o conteúdo da textarea
                    }

                    // Evento de clique no botão de publicar
                    publishButton.addEventListener('click', function() {
                        const postContent = contentInput.value;
                        analyzeContent(postContent);
                    });
                });
            </script>

        @endauth
    @endsection
