@extends('layouts.default')

@section('title', 'Detail')

@section('content')
@if ($errors->any())
<div>
    <h4>Erreurs :</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="detail-container">
<h1 class="titreAdmin"> Détail de : {{ $utilisateur->nom.' '.$utilisateur->prenom}} </h1>

<div class="detailUtil-grid">
  <p> Nom : <span>{{ $utilisateur->nom }}</span> </p>
  <p> Prénom : <span>{{ $utilisateur->prenom }}</span> </p> 
  <p> Email : <span>{{ $utilisateur->email }}</span></p>
  <p> Statut : <span>{{ $utilisateur->nom_statut }} </span></p>
  <p> Rôle : <span>{{ $utilisateur->role }}</span> </p> 
  <p> Genre : <span>{{ $utilisateur->genre }}</span></p> 
  <p> Collège : <span>{{ $utilisateur->college ?? '' }}</span></p> 
  <p> Équipe : <span>{{ $utilisateur->equipe ?? ''}}</span> </p> 
  <p> Commentaire : <textarea readonly class="commentaire-box">{{ $utilisateur->commentaireUtil ?? ''}} </textarea></span> </p> 
</div>

<div class="detail-supression">
  <form id= "formulaire-suppression" action="{{ route('administrateur.supprimer-utilisateur', $utilisateur->id) }}" method="POST">
    @csrf 
    @method('DELETE')
    <button type="submit">Supprimer</button>
  </form>
  
  <a href="{{ route('administrateur.modification-utilisateur', $utilisateur->id) }}">
    <button type="button">Modifier</button>
  </a>
</div>
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