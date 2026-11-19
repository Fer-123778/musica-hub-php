<?php $base = $base ?? ''; ?>
<footer class="footer-musica mt-5 py-4">
    <div class="container text-center">
        <p class="mb-1">&copy; <?= date('Y'); ?> <?= APP_NAME; ?>. Todos los derechos reservados.</p>
        <p class="mb-0">Contacto: <a href="mailto:<?= APP_EMAIL; ?>"><?= APP_EMAIL; ?></a></p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base; ?>js/main.js"></script>
</body>
</html>