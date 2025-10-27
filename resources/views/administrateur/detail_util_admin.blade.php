@extends('layouts.default')

@section('contenu')
  <h1> Détail de : </h1>
  
  <div class="detailUtil">
    <p> Identifiant {{ $utilisateur->id}}: </p>
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
    <form action="{{ route('administrateur.supprimer_util', $utilisateur->id) }}" method="POST">
      @csrf 
      @method('DELETE')
      <button type="submit">Supprimer</button>
    </form>

<a href="{{ route('administrateur.modification_util', $utilisateur->id) }}">
    <button type="button">Modifier</button>
</a>

  </div>
@stop