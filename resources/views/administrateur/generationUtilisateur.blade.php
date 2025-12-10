@extends('layouts.default')

@section('title', 'Génération')

@section('content')

@if ($errors->any())
<div>
    <h4>Erreurs :</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="detail-container"> 
    <h1 class="titreAdmin"> Génération Utilisateur </h1>
    <form action="{{ route('administrateur.ajouter-utilisateur') }}" method="post">
        <div class="detailUtil-grid">
            @csrf
            <div>
                <label for="prenom"> Prénom : </label>
                <input type="text" name="prenom" required>
            </div>
            <!-- "name" est le nom de la personne -->
            <div>
                <label for="name"> Nom : </label> 
                <input type="text" name="name" required> 
            </div>
            <div>
                <label for="email"> Adresse Mail : </label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="genre">Genre : </label>
                <select name="genre" id="genre" required>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->code }}"> {{ $genre->nom }} </option>
                @endforeach
                </select>
            </div>
            <div> 
                <label for="statut"> Statut : </label>
                <select name="statut" id="statut">
                    @foreach ($statuts as $statut)
                        @if ($statut->code == 'N')
                        <option value=" {{ $statut->code }} " selected> {{ $statut->nom }} </option>
                        @else
                        <option value=" {{ $statut->code }} "> {{ $statut->nom }} </option>   
                        @endif
                    @endforeach
                </select> 
            </div>
            <div>
                <label for="concour"> Concour : </label>
                <select name="concour" id="concour" required>
                @foreach ($concours as $concour)
                    <option value="{{ $concour->id }}"> {{ $concour->nom }} </option>
                @endforeach
                </select>
            </div>
            <div>
                <label for="role"> Rôle : </label>
                <select name="role" id="role" required> 
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}"> {{ $role->nom }}</option>
                @endforeach
                </select>
            </div>
            <div>    
                <label for="college"> College : </label>
                <select name="college" id="college"> 
                    <option value="" selected> Aucun </option>
                @foreach ($colleges as $college) 
                    <option value="{{ $college->id }}"> {{ $college->nom.' - '.$college->adr_ville }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="detail-supression">
            <input type="submit" value="Valider">
        </div>   
    </form>
</div>
@endsection