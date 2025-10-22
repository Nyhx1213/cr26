@extends('layouts.default')

@section('contenu')
<h1> Géneration de compte </h1>

<div class="frame"> 
    <form action="{{ route('administrateur.ajouterUtil') }}" method="post">
        @csrf
        <label for="prenom"> Prénom : </label>
        <input type="text" name="prenom" required>
        <!-- "name" est le nom de la personne -->
        <label for="name"> Nom : </label> 
        <input type="text" name="name" required> 
        <label for="email"> Adresse Mail : </label>
        <input type="email" name="email" required>
        <label for="genre">Genre : </label>
        <select name="genre" id="genre" required>
        @foreach ($genres as $genre)
            <option value="{{ $genre->code }}"> {{ $genre->nom }} </option>
        @endforeach
        </select>
        <label for="concour"> Concour : </label>
        <select name="concour" id="concour" required>
        @foreach ($concours as $concour)
            <option value="{{ $concour->id }}"> {{ $concour->nom }} </option>
        @endforeach
        </select>
        <label for="role"> Rôle : </label>
        <select name="role" id="role" required> 
        @foreach ($roles as $role)
            <option value="{{ $role->id }}"> {{ $role->nom }}</option>
        @endforeach
        </select>
        <input type="submit" value="Valider">
    </form>
</div>
@stop