<form method="post" class="tarjeta" data-bs-theme="dark">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo"
               value="<?= h($cancion['titulo']); ?>">
    </div>
    <div class="mb-3">
        <label for="archivo_audio" class="form-label">Archivo de audio (en la carpeta audio)</label>
        <input type="text" class="form-control" id="archivo_audio" name="archivo_audio"
               placeholder="ejemplo: rock1.mp3" value="<?= h($cancion['archivo_audio']); ?>">
    </div>
    <div class="mb-3">
        <label for="id_artista" class="form-label">Artista</label>
        <select class="form-select" id="id_artista" name="id_artista">
            <option value="">Elegí un artista</option>
            <?php foreach ($artistas as $a): ?>
                <option value="<?= h($a['id']); ?>"
                    <?= (string) $cancion['id_artista'] === (string) $a['id'] ? 'selected' : ''; ?>>
                    <?= h($a['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="id_genero" class="form-label">Género</label>
        <select class="form-select" id="id_genero" name="id_genero">
            <option value="">Elegí un género</option>
            <?php foreach ($generos as $g): ?>
                <option value="<?= h($g['id']); ?>"
                    <?= (string) $cancion['id_genero'] === (string) $g['id'] ? 'selected' : ''; ?>>
                    <?= h($g['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-musica"><?= h($texto_boton); ?></button>
    <a href="index.php" class="btn btn-outline-light ms-2">Cancelar</a>
</form>