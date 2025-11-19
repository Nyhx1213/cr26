@extends('layouts.default')

@section('title', 'Modification')

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

<div class="detail-container-bigger">
  <h1 class="titreAdmin"> Modification de {{ $utilisateur->prenom. ' ' . $utilisateur->nom }} </h1>
  <form id="formulaire-modification" action="{{ route('administrateur.action-modification', $utilisateur->id) }}" method="POST">
  <div class="detailUtil-grid">
    @csrf 
    @method('PUT')
    <div>
      <label for="nom"> Nom : </label>
      <input type="text" value="{{ $utilisateur->nom }}" name="nom" required> 
    </div>
    <div>
      <label for="prenom"> Prénom : </label>
      <input type="text" value="{{ $utilisateur->prenom }}" name="prenom" required> 
    </div>
    <div>
      <label for="email"> Email : </label>
      <input type="email" value="{{ $utilisateur->email }}" name="email" required>
    </div>
    <div>
      <label for="motdepasse"> Géneration de mot de passe : </label>
      <input type="checkbox" name="motdepasse"> <br><br>
    </div>
    <div>
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
    </div>
    <div>
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
    </div>
    <div>
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
    </div>
    <div>
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
    </div>
  </div>
  <label for="commentaire"> Commentaire :</label>
  <textarea name="commentaire" id="commentaire"> {{ $utilisateur->commentaire_util }}</textarea>
  <div class="detail-supression">
    <button type="submit" name="valider">Valider</button>
    <a href="{{ route('administrateur.detail-utilisateur', $utilisateur->id) }}">
    <button type="button">Annuler</button>
    </a> 
  </div>
</form>
</div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('formulaire-modification');
      
      form.addEventListener('submit', function(event) {
        const confirmed = confirm("Êtes-vous sûr de vouloir modifier cet utilisateur ? Cette action est irréversible !");
        if (!confirmed) {
          event.preventDefault(); // Annule la soumission du formulaire
        }
      });
    });
  </script>

@endsection