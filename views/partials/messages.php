<?php if (isset($_SESSION['success'])): ?>
    <div style="background-color: #d4edda; padding: 10px; margin: 10px 0; color: #155724;">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background-color: #f8d7da; padding: 10px; margin: 10px 0; color: #721c24;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
