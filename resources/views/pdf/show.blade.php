@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    @if($exists)
        <div class="w-full h-screen">
            <iframe src="{{ asset('storage/pdfs/FAC_000'.$id.'.pdf') }}" width="100%" height="100%"></iframe>
        </div>
    @else
        <div class="w-full h-96 bg-white rounded text-xs text-center flex flex-col justify-center items-center gap-2 px-4 py-8 border-2 border-dashed border-zinc-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-x-icon lucide-file-x"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="m14.5 12.5-5 5"/><path d="m9.5 12.5 5 5"/></svg>
            <p>Archivo no encontrado</p>
        </div>
    @endif
@endsection
