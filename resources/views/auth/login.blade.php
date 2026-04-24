<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Péage Pro — Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
  <!-- jQuery & Select2 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <style>
    * { font-family: 'DM Sans', sans-serif; }
    body { background-color: #f7fafc; }
    
    /* Select2 Tailwind Override */
    .select2-container--default .select2-selection--single {
        border-color: #e5e7eb !important; border-radius: 0.75rem !important; height: 46px !important; display: flex; align-items: center; outline: none !important; margin-top: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important; font-size: 0.875rem !important; padding-left: 0.75rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important; right: 8px !important;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-50">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden shadow-gray-200/50">
      
      <div class="p-8 pb-6 border-b border-gray-100 flex flex-col items-center">
          <div class="w-12 h-12 bg-[#1D9E75] rounded-xl flex items-center justify-center mb-4">
              <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24"><path d="M12 2C8 2 4 5 4 9c0 5 8 13 8 13s8-8 8-13c0-4-4-7-8-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/></svg>
          </div>
          <h2 class="text-2xl font-semibold text-gray-900 mb-1">Péage Pro</h2>
          <p class="text-sm text-gray-400">Veuillez vous identifier pour continuer</p>
      </div>

      <div class="p-8 pt-6 bg-white">
          <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
              @csrf

              @if ($errors->any())
                  <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-sm">
                      <ul class="list-disc list-inside">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse E-mail</label>
                  <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                      </div>
                      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="block w-full pl-10 px-3 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1D9E75]/30 focus:border-[#1D9E75] transition" placeholder="agent@peage.ci">
                  </div>
              </div>

              <div>
                  <label for="guichet_id" class="block text-sm font-medium text-gray-700 mb-1">Guichet d'affectation</label>
                  <select id="guichet_id" name="guichet_id" required class="block w-full px-3 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1D9E75]/30 focus:border-[#1D9E75] transition">
                      <option value="">Sélectionner un guichet...</option>
                      @foreach($guichets as $guichet)
                          <option value="{{ $guichet->id }}">{{ $guichet->code }}</option>
                      @endforeach
                  </select>
              </div>

              <div>
                  <div class="flex items-center justify-between mb-1">
                      <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                  </div>
                  <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                      </div>
                      <input id="password" type="password" name="password" required class="block w-full pl-10 px-3 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1D9E75]/30 focus:border-[#1D9E75] transition" placeholder="••••••••">
                  </div>
              </div>

              <div class="flex items-center justify-between mt-2">
                  <div class="flex items-center">
                      <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#1D9E75] focus:ring-[#1D9E75] border-gray-300 rounded">
                      <label for="remember" class="ml-2 block text-sm text-gray-600">Se souvenir de moi</label>
                  </div>
              </div>

              <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#1D9E75] hover:bg-[#0F6E56] transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D9E75]">
                  Se connecter
              </button>
          </form>
      </div>
  </div>

<script>
$(document).ready(function() {
    $('select').select2({ width: '100%' });
});
</script>
</body>
</html>
