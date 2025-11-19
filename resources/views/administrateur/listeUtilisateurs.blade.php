@extends('layouts.default')

@section('title', 'Liste')

@section('content')

<div class="detail-container-bigger"> 
  <h1 class="titreAdmin"> Liste des utilisateurs </h1>

<!-- Bar de recherche dedier à trouver un utilisateur --> 
  <div class="barRecherche">
    <span>Bar de recherche </span> 
    <input type="text" placeholder="Recherche..">
  </div>

<!-- Tableau qui permet d'afficher et trier le contenu. -->
  <div class="pageUtil">
    <table>
    <thead>
      <tr> 
        <th> <a href="test?tri=nom">Nom</a> </th>
        <th> <a href="test?tri=prenom">Prénom</a> </th>
        <th> <a href="test?tri=mail">Email</a> </th>
        <th> <a href="test?tri=role">Rôle</a> </th>
        <th> Détail </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($les_utilisateurs as $utilisateur)
      <tr>
        <td> {{ $utilisateur->nom }}</td> 
        <td> {{ $utilisateur->prenom }}</td>
        <td> {{ $utilisateur->email }} </td>
        <td> {{ $utilisateur->role ?? 'Aucun' }}</td>
        <td> <a href="{{ route('administrateur.detail-utilisateur', $utilisateur->id) }}"> Détail </td> 
      </tr>
      @endforeach
    </tbody>
    </table>
  </div>
<!-- élement qui permet de choisir la page, les pages s'adapt apropos du nombre d'utilisateurs.  -->
  <div class ="pagination-centre">{{ $les_utilisateurs->links() }} </div>
</div>
@endsection