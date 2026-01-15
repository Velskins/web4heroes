<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<form action="/login" method="POST">
    <div>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div>
        <label for="pwd">Mot de passe :</label>
        <input type="password" id="pwd" name="pwd" required>
    </div>

    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="/register">S'inscrire ici</a></p>