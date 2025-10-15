@extends('layouts.default')

@section('contenu')
  <h1> Détail de : </h1>
  
  <div class="detailUtil">
    <p> Identifiant : </p>
    <p> Nom : </p>
    <p> Prénom : </p> 
    <p> Email : </p>
    <p> Rôle : </p> 
    <p> Genre : </p> 
    <p> Collège : </p> 
    <p> Équipe : </p> 
    <p> Commentaire : </p> 
  </div>
  <div class="positionButtonsDetail">
    <button> Supprimer </button>
    <button> Modifier </button> 
  </div>
@stop