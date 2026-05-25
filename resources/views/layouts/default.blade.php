<!doctype html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Application de gestion du concours de robots des collèges (Deux-Sèvres) : inscriptions, saisie des notes, résultats et informations générales." />
  <link href="{{ asset('css/pico.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <title>@yield('title', 'Concours Robot')</title>
</head>
<style>
  
</style>
<body>
  <div class="wrapper">
    <header>
      @include('includes.header')
    </header>

    @if(session('success'))
      <div id="popup-success" class="popup popup-success">
          {{ session('success') }}
      </div>
    @endif

    @if(session('erreur'))
        <div id="popup-erreur" class="popup popup-erreur">
            {{ session('erreur') }}
        </div>
    @endif

    <main id="main" role="main">
      @yield('content')
    </main>

    @include('includes.footer')
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    setTimeout(function() {
        const success = document.getElementById('popup-success');
        const erreur = document.getElementById('popup-erreur');
        
        if (success) success.style.display = 'none';
        if (erreur) erreurr.style.display = 'none';
    }, 6000);
</script>
