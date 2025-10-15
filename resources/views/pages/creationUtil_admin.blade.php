@extends('layouts.default')

@section('contenu')
<h1> Géneration de compte </h1>

<div class="frame"> 
<form wire:submit="ajouterUtil">
    <label for="prenom"> Prénom : </label>
    <input type="text" wire:model="prenom" required>
    <!-- "name" est le nom de la personne -->
    <label for="name"> Nom : </label> 
    <input type="text" wire:model="prenom" required> 
    <label for="mail"> Adresse Mail : </label>
    <input type="email" wire:model="mail" required>
    <label for="role"> Rôle : </label>
    <select wire:model="role" id="role" required> 
    @foreach ($roles as $role)
        <option value="{{ $role->id }}"> {{ $role->nom }}</option>
    @endforeach
    </select>
    <input type="submit" value="Valider">
</form>
</div>
@stop