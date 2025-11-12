<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title> Concours Robots</title>
  <link rel="stylesheet" href="/css/pico.min.css">
</head>
<body>
<div class="website">
    <header class="header">
        @include('includes.header')
    </header>
    <aside class="aside">
        <nav class="navigation">
            @include('includes.menu')
        </nav>
    </aside>
     <main id="main" class="main">
        @yield('contenu')
    </main>
</div>
</body>
</html>