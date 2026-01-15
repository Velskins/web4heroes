<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<div class="profile-card">
    <h2>Bonjour,
        <?= htmlspecialchars($user['firstname']) ?>
        <?= htmlspecialchars($user['lastname']) ?>
    </h2>

    <ul>
        <li><strong>Email :</strong>
            <?= htmlspecialchars($user['email']) ?>
        </li>
        <li><strong>Date de naissance :</strong>
            <?= htmlspecialchars($user['birthdate']) ?>
        </li>
        <li><strong>Genre :</strong>
            <?= htmlspecialchars($user['gender']) ?>
        </li>
        <li><strong>Rôle :</strong>
            <?php
            $roles = json_decode($user['role'], true);
            echo htmlspecialchars(implode(', ', $roles));
            ?>
        </li>
    </ul>

    <h3>Mon Adresse</h3>
    <p>
        <?= htmlspecialchars($user['street_number'] ?? '') ?>
        <?= htmlspecialchars($user['street'] ?? '') ?><br>
        <?= htmlspecialchars($user['zipcode'] ?? '') ?>
        <?= htmlspecialchars($user['city'] ?? '') ?>
    </p>

    <a href="/logout">Se déconnecter</a>
</div>