<?php
class CancionController
{
    private Cancion $modelo;

    public function __construct(Cancion $modelo)
    {
        $this->modelo = $modelo;
    }

    // Carga una vista pasándole las variables que necesita
    private function vista(string $nombre, array $datos = []): void
    {
        extract($datos);
        $base = '';
        require __DIR__ . '/../Views/' . $nombre . '.php';
    }

    private function datosDelFormulario(): array
    {
        return [
            'titulo' => trim($_POST['titulo'] ?? ''),
            'archivo_audio' => trim($_POST['archivo_audio'] ?? ''),
            'id_artista' => $_POST['id_artista'] ?? '',
            'id_genero' => $_POST['id_genero'] ?? '',
        ];
    }

    private function validar(array $d): array
    {
        $errores = [];
        if ($d['titulo'] === '') {
            $errores[] = 'El título es obligatorio.';
        }
        if ($d['archivo_audio'] === '') {
            $errores[] = 'El archivo de audio es obligatorio.';
        }
        if (!filter_var($d['id_artista'], FILTER_VALIDATE_INT)) {
            $errores[] = 'Elegí un artista.';
        }
        if (!filter_var($d['id_genero'], FILTER_VALIDATE_INT)) {
            $errores[] = 'Elegí un género.';
        }
        return $errores;
    }

    private function redirigir(string $estado): void
    {
        header('Location: canciones.php?status=' . $estado);
        exit;
    }

    public function index(): void
    {
        $mensajes = [
            'created' => 'La canción se agregó correctamente.',
            'updated' => 'La canción se actualizó correctamente.',
            'deleted' => 'La canción se eliminó correctamente.',
        ];
        $estado = $_GET['status'] ?? '';

        $this->vista('canciones/index', [
            'titulo_pagina' => 'Administrar canciones',
            'canciones' => $this->modelo->todas(),
            'mensaje' => $mensajes[$estado] ?? '',
        ]);
    }

    public function crear(): void
    {
        $cancion = ['titulo' => '', 'archivo_audio' => '', 'id_artista' => '', 'id_genero' => ''];
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cancion = $this->datosDelFormulario();
            $errores = $this->validar($cancion);
            if (empty($errores)) {
                $this->modelo->crear($cancion);
                $this->redirigir('created');
            }
        }

        $this->vista('canciones/formulario', [
            'titulo_pagina' => 'Agregar canción',
            'encabezado' => 'Agregar canción',
            'texto_boton' => 'Guardar canción',
            'url_form' => 'canciones.php?accion=crear',
            'cancion' => $cancion,
            'errores' => $errores,
            'artistas' => $this->modelo->artistas(),
            'generos' => $this->modelo->generos(),
        ]);
    }

    public function editar(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $existente = $id ? $this->modelo->buscar($id) : null;
        if (!$existente) {
            header('Location: canciones.php');
            exit;
        }

        $cancion = $existente;
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cancion = $this->datosDelFormulario();
            $errores = $this->validar($cancion);
            if (empty($errores)) {
                $this->modelo->actualizar($id, $cancion);
                $this->redirigir('updated');
            }
        }

        $this->vista('canciones/formulario', [
            'titulo_pagina' => 'Editar canción',
            'encabezado' => 'Editar canción',
            'texto_boton' => 'Guardar cambios',
            'url_form' => 'canciones.php?accion=editar&id=' . $id,
            'cancion' => $cancion,
            'errores' => $errores,
            'artistas' => $this->modelo->artistas(),
            'generos' => $this->modelo->generos(),
        ]);
    }

    public function eliminar(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->modelo->eliminar($id);
        }
        $this->redirigir('deleted');
    }
}