@extends('layouts.default')

@section('contenu')
    <h1> Suppression d'utilisateurs</h1>
    
    <div class="barRecherche">
        <span>Bar de recherche </span> 
        <input type="text" placeholder="Recherche..">
        <button> Recherche </button> 
    </div>

    <table>
        <tr> 
            <th> Selection </th>
            <th> <a href="test?tri=id">Identifiant</a> </th>
            <th> <a href="test?tri=nom">Nom</a> </th>
            <th> <a href="test?tri=prenom">Prénom</a> </th>
            <th> <a href="test?tri=role">Rôle</a> </th>
            <th> <a href="test?tri=mail">Email</a> </th>
            <th> Détail </th>
        </tr>
        <tr>
            <!-- Value contenrait l'id de l'utilisateur, la checkbox peut être pré cocher si l'adminisrateur arrive sur cette page en utilisant le bouton supprimer dans détail -->
            <td><input type="checkbox" name="select" value=""></td> 
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td><button> Consulter </button> </td>
        </tr>
    </table>
<!-- élement qui permet de choisir la page, les pages s'adapt en rapport avec le nombre d'utilisateurs(30 utilisateurs par page par exemple).  -->
  <p> Page :  </p> 
  <button> Supprimer </button>
@stop