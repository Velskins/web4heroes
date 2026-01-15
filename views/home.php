<h1><?= htmlspecialchars($title) ?></h1>
<p><?= htmlspecialchars($message) ?></p>

<div style="margin-top: 20px;">
    <h3>Accès rapide :</h3>
    <ul>
        <li><a href="/incidents">Voir les incidents en cours</a></li>
        <li><a href="/incidents/create">Déclarer un incident</a></li>
        <li><a href="/login">Se connecter</a></li>
        <li><a href="/register">S'inscrire</a></li>
    </ul>
</div>