<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<?php if (isset($error)): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form action="/incidents/create" method="POST">

    <h3>Informations Générales</h3>
    <div>
        <label>Titre de l'incident :</label><br>
        <input type="text" name="title" required value="<?= htmlspecialchars($data['title'] ?? '') ?>">
    </div>

    <div>
        <label>Type de crime :</label><br>
        <input type="text" name="type" placeholder="Ex: Vol, Attaque..." required>
    </div>

    <div>
        <label>Description détaillée :</label><br>
        <textarea name="description" rows="5" cols="40" required></textarea>
    </div>

    <h3>Localisation (Adresse)</h3>
    <div>
        <label>Numéro :</label> <input type="number" name="numero" style="width: 50px;">
        <label>Complément :</label> <input type="text" name="complement_numero">
    </div>
    <div>
        <label>Rue :</label><br>
        <input type="text" name="street" required>
    </div>
    <div>
        <label>Code Postal :</label> <input type="number" name="zipcode" required>
        <label>Ville :</label> <input type="text" name="city" required>
    </div>

    <h3>Suspect (Optionnel)</h3>
    <div>
        <label>Avez-vous identifié un Super-Vilain ?</label><br>
        <select name="villain_profile_id">
            <option value="">-- Inconnu / Pas de vilain --</option>
            <?php foreach ($villains as $villain): ?>
                <option value="<?= $villain['id'] ?>">
                    <?= htmlspecialchars($villain['alias']) ?> (
                    <?= htmlspecialchars($villain['specialty']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <br>
    <button type="submit">Déclarer l'incident</button>
</form>