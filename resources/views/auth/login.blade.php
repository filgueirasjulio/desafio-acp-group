@extends('layouts.auth') 

@section('content')
<div class="flex-grow flex justify-center items-center">
    <div class="w-full max-w-sm p-8 space-y-6 bg-white shadow-md rounded-lg">
        <h1 class="text-xl font-semibold text-gray-800 text-center">Login</h1>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <!-- E-mail -->
            <div class="input-group">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" class="input-field w-full mt-1 @error('email') border-red-500 @enderror" required value="{{ old('email') }}">
            </div>

            <!-- Senha -->
            <div class="input-group">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" class="input-field w-full mt-1 @error('password') border-red-500 @enderror" required>
            </div>

            <!-- Exibição de erro global (se houver) -->
            @if ($errors->any())
                <div class="mt-4 p-2 bg-red-100 text-red-500 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <button type="submit" id="login-button" class="btn-primary w-full mt-4">Login</button>
            </div>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Criar</a>
        </p>
    </div>
</div>
@endsection
