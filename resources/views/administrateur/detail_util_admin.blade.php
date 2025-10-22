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
    <form action="{{ route('administrateur.supprimer_util', $utilisateur->id) }}" method="post">
      @csrf 
      @method('DELETE')
      <button type="submit">Supprimer</button>
    </form>
    <form action=" {{ route('administrateur.modification_util', $utilisateur->id) }} " method="POST">
      @csrf
      @method('PUT')
      <button type="submit"> Modifier </button>
    </form>
  </div>
@stop