<h1><?= htmlspecialchars($title) ?></h1>
<p><?= htmlspecialchars($message) ?></p>


<!--A METTRE DANS UN COMPOSANT NAV et l'importer */-->
<div style="margin-top: 20px;">
    <h3>Accès rapide :</h3>
    <ul>
        <li><a href="/incident">Voir les incidents en cours</a></li>
        <li><a href="/incident/create">Déclarer un incident</a></li>
        <li><a href="/login">Se connecter</a></li>
        <li><a href="/register">S'inscrire</a></li>
    </ul>
</div>