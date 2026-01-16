<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<?php if (isset($error)): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/register" method="POST">

</form>