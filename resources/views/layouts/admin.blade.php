<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Péage Pro — @yield('title', 'Tableau de bord')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
  <!-- Optional: Include modal or other global dependencies -->
  <!-- CSS -->
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    * { font-family: 'DM Sans', sans-serif; }
    .font-mono { font-family: 'DM Mono', monospace; }

    /* Sidebar nav active */
    .nav-link { transition: all 0.18s ease; }
    .nav-link.active { background: #E1F5EE; color: #0F6E56; }
    .nav-link:not(.active):hover { background: #f3f4f6; }

    /* Progress bar */
    .progress-fill { transition: width 0.6s ease; }

    /* Timer blink */
    @keyframes pulse-green { 0%,100%{opacity:1} 50%{opacity:0.5} }
    .timer-dot { animation: pulse-green 1.5s infinite; }

    /* Pill badges */
    .pill-green  { background:#E1F5EE; color:#0F6E56; }
    .pill-amber  { background:#FAEEDA; color:#854F0B; }
    .pill-blue   { background:#E6F1FB; color:#185FA5; }
    .pill-red    { background:#FCEBEB; color:#A32D2D; }
    .pill-gray   { background:#F1EFE8; color:#5F5E5A; }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 99px; }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex h-screen overflow-hidden">

  <!-- ===== SIDEBAR ===== -->
  <aside class="w-52 bg-white border-r border-gray-100 flex flex-col flex-shrink-0">

    <!-- Logo -->
    <div class="px-5 py-5 border-b border-gray-100">
      <div class="w-9 h-9 bg-[#1D9E75] rounded-xl flex items-center justify-center mb-3">
        <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24"><path d="M12 2C8 2 4 5 4 9c0 5 8 13 8 13s8-8 8-13c0-4-4-7-8-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/></svg>
      </div>
      <p class="text-sm font-semibold text-gray-800">Péage Pro</p>
      <p class="text-xs text-gray-400">Gestion des paiements</p>
    </div>

    <!-- Nav Menu -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
      <p class="text-[10px] text-gray-400 uppercase tracking-widest px-2 mb-2">Menu</p>

      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        Tableau de bord
      </a>

      <a href="{{ route('admin.paiements.index') }}" class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Transactions
        <span class="ml-auto bg-[#1D9E75] text-white text-[10px] px-2 py-0.5 rounded-full">18</span>
      </a>

      <a href="{{ route('admin.guichets.index') }}" class="nav-link {{ request()->routeIs('admin.guichets.*') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        Guichets
      </a>

      <a href="{{ route('admin.rapports.index') }}" class="nav-link {{ request()->routeIs('admin.rapports.*') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        Rapports
      </a>

      <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        Agents
      </a>

      <div class="pt-4">
        <p class="text-[10px] text-gray-400 uppercase tracking-widest px-2 mb-2">Général</p>
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
          Paramètres
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mt-1" onclick="if(confirm('Voulez-vous vraiment vous déconnecter ?')) { document.getElementById('logout-form').submit(); } return false;">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
          Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') ?? '#' }}" method="POST" class="hidden">
            @csrf
        </form>
      </div>
    </nav>
  </aside>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="flex-1 overflow-y-auto bg-gray-50">
    <div class="p-6 max-w-7xl mx-auto">
      @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl relative">
          <h4 class="text-sm font-semibold mb-1">Veuillez corriger les erreurs suivantes :</h4>
          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="mb-5 p-4 bg-[#E1F5EE] border border-[#1D9E75]/20 text-[#0F6E56] rounded-xl flex items-center gap-3">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
      @endif

      @yield('content')
    </div>
  </main>
</div>

<!-- ===== JAVASCRIPT ===== -->
@stack('scripts')
</body>
</html>
