@extends('layouts.default')

@section('contenu')

<h1> Modification de : </h1>

<form action="{{ route('administrateur.action_modifier_util', $utilisateur->id) }}" method="POST">
    @csrf 
    @method('PUT')
    <label for="nom"> Nom : </label>
    <input type="text" value="{{ $utilisateur->nom }}" name="nom" required> 
    <label for="prenom"> Prénom : </label>
    <input type="text" value="{{ $utilisateur->prenom }}" name="prenom" required> 
    <label for="email"> Email : </label>
    <input type="email" value="{{ $utilisateur->email }}" name="email" required>
    <label for="motdepasse"> Modifier mot de passe : </label>
    <input type="checkbox" name="motdepasse"> <br><br>
    <label for="role"> Rôle : </label>
    <select name="role" id="role" required> 
    @foreach ($les_roles as $role)
        @if ($role->id == $utilisateur->id_role)
        <option value="{{ $role->id }}" selected> {{ $role->nom }}</option>
        @else 
        <option value="{{ $role->id }}">{{ $role->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="genre"> Genre : </label>
    <select name="genre" id="genre" required>
    @foreach ($les_genres as $genre)
        @if ($genre->code == $utilisateur->code_genre)
        <option value="{{ $genre->code }}" selected>{{ $genre->nom }}</option>
        @else 
        <option value="{{ $genre->code }}">{{ $genre->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="college"> Collège : </label>
    <select name="college" id="college">
        <option value="" selected>Aucune</option>
    @foreach ($les_colleges as $college)
        @if ($college->id == $utilisateur->id_college)
        <option value="{{ $college->id }}" selected>{{ $college->nom }}</option>
        @else 
        <option value="{{ $college->id }}">{{ $college->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="concour"> Concour : </label>
    <select name="concour" id="concour">
    @foreach ($les_concours as $concour)
        @if ($concour->id == $utilisateur->id_concour )
        <option value="{{ $concour->id }}" selected>{{ $concour->nom }}</option>
        @else
        <option value="{{ $concour->id }}">{{ $concour->nom }}</option>
        @endif
    @endforeach
    </select>
    <label for="commentaire"> Commentaire :</label>
    <textarea name="commentaire" id="commentaire"> {{ $utilisateur->commentaire_util }}</textarea>
    <input type="submit" name="submit">
</form>

@stop