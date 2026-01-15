<h1>Détail de l'incident #
    <?= htmlspecialchars($incident['id']) ?>
</h1>

<div style="border: 1px solid #ccc; padding: 20px;">
    <h2>
        <?= htmlspecialchars($incident['title']) ?> <small>(
            <?= htmlspecialchars($incident['status']) ?>)
        </small>
    </h2>

    <p><strong>Date :</strong>
        <?= htmlspecialchars($incident['date']) ?>
    </p>
    <p><strong>Type :</strong>
        <?= htmlspecialchars($incident['type']) ?>
    </p>
    <p><strong>Priorité :</strong>
        <?= htmlspecialchars($incident['priority']) ?>
    </p>

    <hr>

    <h3>Description</h3>
    <p>
        <?= nl2br(htmlspecialchars($incident['description'])) ?>
    </p>

    <hr>

    <h3>Lieu</h3>
    <p>
        <?= htmlspecialchars($incident['numero']) ?>
        <?= htmlspecialchars($incident['street']) ?><br>
        <?= htmlspecialchars($incident['zipcode']) ?>
        <?= htmlspecialchars($incident['city']) ?>
    </p>

    <hr>

    <h3>Implication</h3>
    <p><strong>Déclaré par :</strong>
        <?= htmlspecialchars($incident['reporter_firstname']) ?>
        <?= htmlspecialchars($incident['reporter_lastname']) ?>
    </p>

    <?php if (!empty($incident['villain_alias'])): ?>
        <p style="color: red;"><strong>Super-Vilain identifié :</strong>
            <?= htmlspecialchars($incident['villain_alias']) ?>
        </p>
    <?php else: ?>
        <p><em>Aucun super-vilain identifié pour le moment.</em></p>
    <?php endif; ?>
</div>

<p><a href="/incidents">Retour à la liste</a></p>