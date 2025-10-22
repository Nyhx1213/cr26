@extends('layouts.default')

@section('contenu')
  <h1> Liste des utilisateurs </h1>

<!-- Bar de recherche dedier à trouver un utilisateur --> 
  <div class="barRecherche">
    <span>Bar de recherche </span> 
    <input type="text" placeholder="Recherche..">
    <button> Recherche </button> 
  </div>

<!-- Tableau qui permet d'afficher et trier le contenu. -->
  <table>
    <tr> 
      <th> <a href="test?tri=nom">Nom</a> </th>
      <th> <a href="test?tri=prenom">Prénom</a> </th>
      <th> <a href="test?tri=mail">Email</a> </th>
      <th> <a href="test?tri=role">Rôle</a> </th>
      <th> Détail </th>
    </tr>
    @foreach ($les_utilisateurs as $utilisateur)
    <tr>
      <td> {{ $utilisateur->nom }}</td> 
      <td> {{ $utilisateur->prenom }}</td>
      <td> {{ $utilisateur->email }} </td>
      <td> {{ $utilisateur->role ?? 'Aucun' }}</td>
      <td> <a href="{{ route('administrateur.detail_util', $utilisateur->id) }}"> Détail </td> 
    </tr>
    @endforeach
  </table>
<!-- élement qui permet de choisir la page, les pages s'adapt apropos du nombre d'utilisateurs.  -->
  <p>{{ $les_utilisateurs->links() }} </p> 

@stop