<!DOCTYPE html>
<html>
<body>
    <h2>Bonjour {{ $user->prenom }} {{ $user->nom }}</h2>

    <p>Voici vos informations de connexion :</p>
    <ul>
        <li><strong></li>
        <li><strong>Email :</strong> {{ $user->email }}</li>
        <li><strong>Mot de passe :</strong> {{ $motdepasse }}</li>
    </ul>

    <p>Il est recommender de changer le mot de passe.</p>

    <p>
        Cordialement,
        <br>
        L’équipe {{ config('app.name') }}
    </p>
</body>
</html>