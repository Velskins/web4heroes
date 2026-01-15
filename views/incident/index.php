<h1><?= htmlspecialchars($title) ?></h1>

<p><a href="/incidents/create" style="background: blue; color: white; padding: 5px;">+ Déclarer un nouvel incident</a></p>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Date</th>
            <th>Titre</th>
            <th>Type</th>
            <th>Ville</th>
            <th>Priorité</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($incidents as $inc): ?>
        <tr>
            <td><?= htmlspecialchars($inc['date']) ?></td>
            <td><?= htmlspecialchars($inc['title']) ?></td>
            <td><?= htmlspecialchars($inc['type']) ?></td>
            <td><?= htmlspecialchars($inc['city']) ?></td> 
            <td><?= htmlspecialchars($inc['priority']) ?></td>
            <td><?= htmlspecialchars($inc['status']) ?></td>
            <td>
                <a href="/incidents/show?id=<?= $inc['id'] ?>">Voir détails</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>