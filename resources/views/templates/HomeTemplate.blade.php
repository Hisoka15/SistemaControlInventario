@extends('layouts.app')
@section('layoutContent')
    <main class="w-full flex justify-stretch items-start h-screen bg-background-primary gap-4">
        <nav class="flex flex-col justify-between items-start p-2 pl-0 shadow-xl w-full bg-navbar-primary max-w-[18rem] h-full overflow-auto scrollbar-hidden">
            <div class="p-4 flex flex-col justify-center items-start">
                <h2 class="w-full h-auto text-base font-bold text-font-primary">{{Auth::user()->name}}</h2>
                <p class="text-xs text-font-secondary">{{Auth::user()->email}}</p>
            </div>
            <div class="w-full">
                <div class="flex flex-col gap-2 w-full mb-2">
                    <a href="{{route('dashboard')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-line-icon lucide-chart-line"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        Panel de control
                    </a>
                    <a href="{{route('users.index')}}" class="text-xs transition-all hover:scale-105 w-full h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('users.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                        Usuarios
                    </a>
                    <a href="{{route('products.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('products.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-search-icon lucide-package-search"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><circle cx="18.5" cy="15.5" r="2.5"/><path d="M20.27 17.27 22 19"/></svg>
                        Productos
                    </a>
                    <a href="{{route('purchases.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('purchases.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        Compras
                    </a>
                    <a href="{{route('sales.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('sales.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag-icon lucide-shopping-bag"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        Ventas
                    </a>
                    <a href="{{route('inventory.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('inventory.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-forklift"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 17l5 0" /><path d="M3 17v-6h13v6" /><path d="M5 11v-4h4" /><path d="M9 11v-6h4l3 6" /><path d="M22 15h-3v-10" /><path d="M16 13l3 0" /></svg>
                        Inventario
                    </a>
                    <a href="{{route('reports.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('reports.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-chart-pie-icon lucide-file-chart-pie"><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3.5"/><path d="M4.017 11.512a6 6 0 1 0 8.466 8.475"/><path d="M9 16a1 1 0 0 1-1-1v-4c0-.552.45-1.008.995-.917a6 6 0 0 1 4.922 4.922c.091.544-.365.995-.917.995z"/></svg>
                        Reportes
                    </a>
                    <a href="{{route('backups.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('backups.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-database"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6m-8 0a8 3 0 1 0 16 0a8 3 0 1 0 -16 0" /><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        Copias de seguridad
                    </a>
                    <a href="{{route('configuration.index')}}" class="text-xs w-full transition-all hover:scale-105 h-10 px-4 transition-all flex justify-start items-center gap-4 bg-transparent font-base {{ request()->routeIs('configuration.index') ? 'text-white' : 'text-[#555]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog-icon lucide-cog"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>
                        Configuraciones
                    </a>
                </div>
            </div>
            <div class="w-full pl-4 pt-2 flex flex-col gap-2">
                <a href="{{route('process-logout')}}" class="w-full h-10 text-xs text-red-600 text-[#555] bg-transparent gap-4 flex justify-start items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Cerrar sesi&oacute;n
                </a>
            </div>
        </nav>
        <div class="w-full h-screen flex flex-col justify-start items-start gap-2 p-4 pr-4 overflow-auto scrollbar-hidden">
            @yield('HomeTemplateContent')
        </div>
    </main>
@endsection
