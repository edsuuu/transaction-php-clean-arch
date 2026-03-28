<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts._head')
<body class="min-h-screen" style="background: #1a0533;">

    {{-- Sidebar / Navbar --}}
    <div class="flex min-h-screen">

        {{-- Sidebar Desktop --}}
        <aside class="hidden lg:flex flex-col w-64 border-r border-purple-900/30 p-6 gap-2" style="background:#241040;">
            <div class="mb-8">
                <span class="text-2xl font-black text-white tracking-tight">nu<span style="color:#820ad1;">bank</span></span>
            </div>

            <nav class="flex-1 flex flex-col gap-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-purple-900/40 text-white' : 'text-purple-300 hover:bg-purple-900/20 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Início
                </a>
                <a href="{{ route('deposit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('deposit') ? 'bg-purple-900/40 text-white' : 'text-purple-300 hover:bg-purple-900/20 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Depositar
                </a>
                <a href="{{ route('transfer') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('transfer') ? 'bg-purple-900/40 text-white' : 'text-purple-300 hover:bg-purple-900/20 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Transferir
                </a>
                <a href="{{ route('history') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('history') ? 'bg-purple-900/40 text-white' : 'text-purple-300 hover:bg-purple-900/20 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Extrato
                </a>
            </nav>

            <div class="mt-auto pt-4 border-t border-purple-900/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-purple-300 hover:bg-red-900/20 hover:text-red-400 transition-colors text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">

            {{-- Mobile Topbar --}}
            <header class="lg:hidden flex items-center justify-between px-4 py-4 border-b border-purple-900/30" style="background:#241040;">
                <span class="text-xl font-black text-white">nu<span style="color:#820ad1;">bank</span></span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('deposit') }}" class="p-2 text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </a>
                    <a href="{{ route('transfer') }}" class="p-2 text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </a>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- Mobile Bottom Nav --}}
            <nav class="lg:hidden flex border-t border-purple-900/30 py-2" style="background:#241040;">
                <a href="{{ route('dashboard') }}" class="flex-1 flex flex-col items-center gap-1 py-2 text-xs font-semibold {{ request()->routeIs('dashboard') ? 'text-purple-400' : 'text-purple-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Início
                </a>
                <a href="{{ route('deposit') }}" class="flex-1 flex flex-col items-center gap-1 py-2 text-xs font-semibold {{ request()->routeIs('deposit') ? 'text-purple-400' : 'text-purple-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Depositar
                </a>
                <a href="{{ route('transfer') }}" class="flex-1 flex flex-col items-center gap-1 py-2 text-xs font-semibold {{ request()->routeIs('transfer') ? 'text-purple-400' : 'text-purple-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Transferir
                </a>
                <a href="{{ route('history') }}" class="flex-1 flex flex-col items-center gap-1 py-2 text-xs font-semibold {{ request()->routeIs('history') ? 'text-purple-400' : 'text-purple-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Extrato
                </a>
            </nav>
        </div>
    </div>

    @livewireScripts
</body>
</html>
