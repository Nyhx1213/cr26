@extends('layouts.default')

@section('contenu')

<h1> Modification de : </h1>

<form action="administrateur-detail?id=" method="POST">
    <label for="nom"> Nom : </label>
    <input type="text" value="{{ $utilisateur->nom }}" name="nom"> 
    <label for="prenom"> Prénom : </label>
    <input type="text" value="{{ $utilisateur->prenom }}" name="prenom"> 
    <label for="email"> Email : </label>
    <input type="email" value="{{ $utilisateur->email }}" name="email">
    <label for="motdepasse"> Modifier mot de passe : </label>
    <select name="motdepasse" id="motdepasse">
        <option value="non" default>Non</option>
        <option value="oui"> Oui </option>
    </select>
    <label for="role"> Rôle : </label>
    <select name="role" id="role"> 
    @foreach ($les_roles as $role)
        @if ($role->id == $utilisateur->id_role)
        <option value="{{ $role->id }}" default> {{ $role->nom }}</option>
        @else 
        <option value="{{ $role->id }}">{{ $role->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="genre"> Genre : </label>
    <select name="genre" id="genre">
    @foreach ($les_genres as $genre)
        @if ($genre->code == $utilisateur->code_genre)
        <option value="{{ $genre->id }}" default>{{ $genre->nom }}</option>
        @else 
        <option value="{{ $genre->id }}">{{ $genre->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="college"> Collège : </label>
    <select name="college" id="college">
    @foreach ($les_colleges as $college)
        @if ($college->id == $utilisateur->id_college)
        <option value="{{ $college->id }}" default>{{ $college->nom }}</option>
        @else 
        <option value="{{ $college->id }}">{{ $college->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="equipe"> Équipe : </label>
    <select name="equipe" id="equipe">
    @foreach ($les_equipes as $equipe)
        @if ($equipe->id == $utilisateur->id_equipe)
        <option value="{{ $equipe->id }}" default>{{ $equipe->nom }}</option>
        @else 
        <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="commentaire"> Commentaire :</label>
    <textarea name="commentaire" id="commentaire" value=""> {{ $utilisateur->commentaire_util }}</textarea>
</form>

@stop