@extends('layouts.default')

@section('title', 'Detail')

@section('content')

<h1> Détail de : </h1>

<div class="detailUtil">
  <p> Nom : {{ $utilisateur->nom }} </p>
  <p> Prénom : {{ $utilisateur->prenom }} </p> 
  <p> Email : {{ $utilisateur->email }}</p>
  <p> Rôle : {{ $utilisateur->role }} </p> 
  <p> Genre : {{ $utilisateur->genre }}</p> 
  <p> Collège : {{ $utilisateur->college ?? '' }}</p> 
  <p> Équipe : {{ $utilisateur->equipe ?? ''}}: </p> 
  <p> Commentaire : {{ $utilisateur->commentaireUtil ?? ''}} </p> 
</div>
<div class="positionButtonsDetail">
  <form id= "formulaire-suppression" action="{{ route('administrateur.supprimer-utilisateur', $utilisateur->id) }}" method="POST">
    @csrf 
    @method('DELETE')
    <button type="submit">Supprimer</button>
  </form>
  
  <a href="{{ route('administrateur.modification-utilisateur', $utilisateur->id) }}">
    <button type="button">Modifier</button>
  </a>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formulaire-suppression');
    
    form.addEventListener('submit', function(event) {
      const confirmed = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible !");
      if (!confirmed) {
        event.preventDefault(); // Annule la soumission du formulaire
      }
    });
  });
  </script>
@endsection