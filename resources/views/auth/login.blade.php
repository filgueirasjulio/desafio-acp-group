@extends('layouts.auth') 

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-md rounded-lg">      
            <login-form></login-form>
        </div>
    </div>
@endsection
