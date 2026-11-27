<?= $this->extend('layout') ?>

<?= $this->section('contenido') ?>
<main class="container py-5" style="max-width: 900px;">
    <h1 class="mb-2">Canciones</h1>
    <p class="texto-suave mb-4">Listado generado con CodeIgniter.</p>

    <form method="get" action="<?= base_url('canciones-ci') ?>" class="tarjeta mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="q" class="form-label">Título o artista</label>
                <input type="search" class="form-control" id="q" name="q" maxlength="50" value="<?= esc($q) ?>">
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero">
                    <option value="">Todos</option>
                    <?php foreach ($generos as $g): ?>
                        <option value="<?= esc($g) ?>" <?= $genero === $g ? 'selected' : '' ?>><?= esc($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-musica w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <p class="texto-suave"><?= count($canciones) ?> canción(es)</p>

    <?php if (empty($canciones)): ?>
        <div class="alert alert-warning">No hay canciones con esos criterios.</div>
    <?php endif; ?>

    <?php foreach ($canciones as $c): ?>
        <div class="tarjeta mb-3">
            <h2 class="h5"><?= esc($c['titulo']) ?></h2>
            <p class="texto-suave mb-2"><?= esc($c['artista']) ?> · <?= esc($c['genero']) ?></p>
            <audio controls preload="none" class="w-100"
                   src="/musica-hub-php/audio/<?= esc($c['archivo_audio'], 'url') ?>"></audio>
        </div>
    <?php endforeach; ?>
</main>
<?= $this->endSection() ?>