<?php

use App\Livewire\Actions\Logout;
use function Livewire\Volt\action;

$logout = action(function (Logout $logoutAction) {
    $logoutAction();
    $this->redirect('/', navigate: true);
});
?>
<nav class="navbar">
    <div class="navbar-brand">
        <a href="{{ route('home') }}">Projet concours-robots</a>
        <button class="burger" id="burger">
            <span></span><span></span><span></span>
        </button>
    </div>

    <ul class="nav-links" id="nav-links">
        <li><a href="{{ route('home') }}">Accueil</a></li>

        @guest
        <li class="dropdown">
            <a href="#">Collèges ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('colleges.eleves') }}">Élèves</a></li>
                <li><a href="{{ route('colleges.equipe') }}">Équipe</a></li>
            </ul>
        </li>

        <li><a href="{{ route('epreuves.index') }}">Épreuves</a></li>
        <li><a href="{{ route('classement.index') }}">Classement</a></li>

        <li class="dropdown">
            <a href="#">Édition ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('edition.2024') }}">2024</a></li>
                <li><a href="{{ route('edition.2025') }}">2025</a></li>
            </ul>
        </li>

        @if (Route::has('login'))
        <li><a href="{{ route('login') }}">Connexion</a></li>
        @endif
        @if (Route::has('register'))
        <li><a href="{{ route('register') }}">Inscription</a></li>
        @endif
        @else
        <li class="dropdown">
            <a href="#">Collèges ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('colleges.eleves') }}">Élèves</a></li>
                <li><a href="{{ route('colleges.equipe') }}">Équipe</a></li>
            </ul>
        </li>

        <li><a href="{{ route('epreuves.index') }}">Épreuves</a></li>
        <li><a href="{{ route('classement.index') }}">Classement</a></li>

        <li class="dropdown">
            <a href="#">Édition ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('edition.2024') }}">2024</a></li>
                <li><a href="{{ route('edition.2025') }}">2025</a></li>
            </ul>
        </li>

        <li><a href="{{ route('saisieNote.index') }}">Saisie Note</a></li>

        <li class="dropdown">
            <a href="#">Page Gestion ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('gestion.epreuves') }}">Épreuves</a></li>
                <li><a href="{{ route('gestion.colleges') }}">Collèges</a></li>
                <li><a href="{{ route('gestion.abonnement') }}">Abonnement</a></li>
                <li><a href="{{ route('gestion.role') }}">Rôle</a></li>
                <li class="dropdown">
                    <a href="#">Résultat ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('gestion.edition') }}">Édition</a></li>
                        <li><a href="{{ route('gestion.exportation') }}">Exportation</a></li>
                        <li><a href="{{ route('gestion.modification') }}">Modification</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#">Page Admin ▾</a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('admin.genre') }}">Genre</a></li>
                <li class="dropdown">
                    <a href="#">Gestion Utilisateurs ▾</a>
                    <ul class="dropdown-menu">
                        <a href="{{ route('administrateur.liste-utilisateurs') }}">Liste-Utilisateurs</a></li>
                        <a href="{{ route('administrateur.generation-utilisateur') }}">Génération de compte</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.pays') }}">Pays</a></li>
            </ul>
        </li>

        <!-- Déconnexion -->
        <li>
        @livewire('layout.navigation')
        </li>
        @endguest
    </ul>
</nav>

<script>
    const burger = document.getElementById('burger');
    const navLinks = document.getElementById('nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
</script>