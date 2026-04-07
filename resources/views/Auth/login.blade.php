@extends('templates.mainTemplate')
@section('mainTemplateContent')
    <section class="flex flex-col justify-start items-start w-full gap-2 bg-white/60 backdrop-blur-2xl p-4 rounded max-w-[30rem] mx-auto py-10">
        <h1 class="text-3xl text-zinc-800 font-bold">Login</h1>
        <h4 class="text-md font-semibold text-center text-zinc-400">Ingrese sus credenciales de acceso</h4>
        <form action="{{route('process-login')}}" class="my-6 flex flex-col gap-2 w-full" method="POST">
            @csrf
            <div class="w-full">
                <label for="email" class="block text-sm font-semibold text-lg text-zinc-700">Email</label>
                <input type="email" placeholder="user@example.com" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-zinc-300 rounded-md shadow-sm focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-xs" required>
            </div>
            <div class="w-full">
                <label for="password" class="block text-sm font-semibold text-lg text-zinc-700">Contrase&ntilde;a</label>
                <input type="password" placeholder="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-zinc-300 rounded-md shadow-sm focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-xs" required>
            </div>
            <button type="submit" class="w-full mt-4 bg-[#047342] hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-md">Ingresar</button>
        </form>
        @if (session('error'))
            <div class="w-full bg-red-500 text-white font-semibold text-lg p-2 rounded-md">
                {{session('error')}}
            </div>
        @endif
    </section>
@endsection
