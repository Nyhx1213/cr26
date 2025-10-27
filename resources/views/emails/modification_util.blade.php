<!DOCTYPE html>
<html>
<body>
    <h2>Bonjour,</h2>

    <p>Vous informations on été modifier par un administrateur.</p>
    <p>Voici vos Identifiants : </p>
    <ul>
        <li><strong></li>
        <li><strong>login :</strong> {{ $user }}</li>
        <li><strong>Mot de passe :</strong> {{ $motdepasse }}</li>
    </ul>

    <p>
        Cordialement,
        <br>
        L’équipe {{ config('app.name') }}
    </p>
</body>
</html>