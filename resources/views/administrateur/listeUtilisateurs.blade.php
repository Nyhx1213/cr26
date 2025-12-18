@extends('layouts.default')

@section('title', 'Liste')

@section('content')

<div class="detail-container-bigger"> 
  <h1 class="titreAdmin"> Liste des utilisateurs </h1>

<!-- Bar de recherche dedier à trouver un utilisateur --> 

    <form action="{{ route('administrateur.liste-utilbymail') }}" method=POST> 
      @csrf
      <div class="barRecherche">
        <label for="contenu"> Bar de recherche</label>
        <input type="text" name="contenu" placeholder="Adresse Email" value="">
        <button type="submit"> Valider </button>
    </div>
    <div>
      <label for ="role"> Roles </label>
      <select name="role"> 
        <option value="" default> </option>
        @foreach($les_roles as $le_role)
        <option value="{{ $le_role->id }}"> {{ $le_role->nom }} </option>
        @endforeach
      </select>
    </div>
    <button type="submit"> Valider </button>
    </form>  


<!-- Tableau qui permet d'afficher et trier le contenu. -->

  <div class="pageUtil">
    <form action=" {{ route('administrateur.suppMultiple') }} " method=POST>
      @csrf
    <table>
    <thead>
      <tr> 
        <th> <a href="test?tri=nom">Nom</a> </th>
        <th> <a href="test?tri=prenom">Prénom</a> </th>
        <th> <a href="test?tri=mail">Email</a> </th>
        <th> <a href="test?tri=role">Rôle</a> </th>
        <th> Détail </th>
        <th> Suppression </th>
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
        <td><input type="checkbox" name="ids[]" value="{{ $utilisateur->id }}"> </td>
      </tr>
      @endforeach
    </tbody>
    </table>
    <button type="submit"> Supprimer </button>
    </form>
  </div>
<!-- élement qui permet de choisir la page, les pages s'adapt apropos du nombre d'utilisateurs.  -->
  <div class ="pagination-centre">{{ $les_utilisateurs->links() }} </div>
</div>
@endsection