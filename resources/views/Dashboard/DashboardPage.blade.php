@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <span class="w-full flex flex-col">
        <h2 class="text-md font-bold">Buen dia, {{Auth::user()->name}}</h2>
        <h4 class="text-font-secondary text-xs">Bienvenido al sistema de control de inventario</h4>
    </span>
    <div class="w-full grid grid-cols-2 gap-2 text-md">
        <div class="bg-white p-4 rounded flex flex-col gap-4 col-span-2">
            <div class="h-full flex justify-center items-center" id="containerChartLine">
                <div class="w-full" id="chartLine"></div>
            </div>
        </div>
        <div class="bg-white p-4 rounded flex flex-col gap-4 col-span-2">
            <div class="h-full flex justify-center items-center" id="containerChartBar">
                <div class="w-full" id="chartBar"></div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/dashboard.js')}}"></script>
@endsection
