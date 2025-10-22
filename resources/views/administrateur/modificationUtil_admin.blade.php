@extends('layouts.default')

@section('contenu')

<h1> Modification de : </h1>

<form action="administrateur-detail?id=" method="POST">
    <label for="nom"> Nom : </label>
    <input type="text" value="" name="nom"> 
    <label for="prenom"> Prénom : </label>
    <input type="text" value="" name="prenom"> 
    <label for="email"> Email : </label>
    <input type="email" value="" name="email">
    <label for="motdepasse"> Mot de passe : </label>
    <input type="password" name="motdepasse">
    <label for="role"> Rôle : </label>
    <select name="role" id="genre"> 
        <option value=""> unRole </option>
    </select>
    <label for="genre"> Genre : </label>
    <select name="genre" id="genre">
        <option value="">unGenre</option>
    </select>
    <label for="college"> Collège : </label>
    <select name="college" id="college">
        <option value=""> unCollège </option>
    </select>
    <label for="equipe"> Équipe : </label>
    <select name="equipe" id="equipe">
        <option value=""> uneÉquipe</option>
    </select>
    <label for="commentaire"> Commentaire :</label>
    <textarea name="commentaire" id="commentaire" value=""></textarea>
</form>

@stop