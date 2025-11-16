<!doctype html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Application de gestion du concours de robots des collèges (Deux-Sèvres) : inscriptions, saisie des notes, résultats et informations générales." />
  <link href="/css/pico.css" rel="stylesheet" />
  <link href="/css/style.css" rel="stylesheet" />
  <title>@yield('title', 'Concours Robot')</title>
</head>
<style>
  
</style>
<body>
  <div class="wrapper">
    <header>
      @include('includes.header')
    </header>

    <main id="main" role="main">
      @yield('content')
    </main>

    @include('includes.footer')
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
