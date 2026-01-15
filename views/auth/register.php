<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<?php if (isset($error)): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/register" method="POST">
    <div>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>
    </div>
    <div>
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>
    </div>

    <div>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="pwd">Mot de passe :</label>
        <input type="password" id="pwd" name="pwd" required>
    </div>

    <div>
        <label for="birthdate">Date de naissance :</label>
        <input type="date" id="birthdate" name="birthdate" required>
    </div>

    <div>
        <label for="gender">Genre :</label>
        <select name="gender" id="gender">
            <option value="Male">Homme</option>
            <option value="Femelle">Femme</option>
            <option value="Other">Autre</option>
        </select>
    </div>

    <div style="margin: 15px 0;">
        <input type="checkbox" id="is_hero" name="is_hero" value="1">
        <label for="is_hero"><strong>Je souhaite m'inscrire en tant que Super-Héros</strong> (soumis à
            validation)</label>
    </div>

    <button type="submit">Créer mon compte</button>
</form>