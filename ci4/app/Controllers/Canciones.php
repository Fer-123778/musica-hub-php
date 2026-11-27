<?php

namespace App\Controllers;

use App\Models\CancionModel;
use CodeIgniter\HTTP\ResponseInterface;

class Canciones extends BaseController
{
    private array $generosValidos = ['Rock', 'Pop', 'Indie', 'Hip-Hop', 'Electrónica', 'Metal'];

    public function index(): string
    {
        $q = mb_substr(trim((string) $this->request->getGet('q')), 0, 50);
        $genero = trim((string) $this->request->getGet('genero'));
        if (!in_array($genero, $this->generosValidos, true)) {
            $genero = '';
        }

        $modelo = new CancionModel();

        return view('canciones/lista', [
            'titulo'    => 'Canciones (CodeIgniter)',
            'canciones' => $modelo->conDetalle($q, $genero),
            'q'         => $q,
            'genero'    => $genero,
            'generos'   => $this->generosValidos,
        ]);
    }

    public function apiJson(): ResponseInterface
    {
        $q = trim((string) $this->request->getGet('q'));
        $genero = trim((string) $this->request->getGet('genero'));

        if (mb_strlen($q) > 50) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'La búsqueda no puede superar los 50 caracteres.',
            ]);
        }
        if ($genero !== '' && !in_array($genero, $this->generosValidos, true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'El género elegido no es válido.',
            ]);
        }

        $datos = (new CancionModel())->conDetalle($q, $genero);

        if (($q !== '' || $genero !== '') && empty($datos)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'not_found',
                'message' => 'No se encontraron canciones.',
                'data'    => [],
            ]);
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'total'  => count($datos),
            'data'   => $datos,
        ]);
    }
}