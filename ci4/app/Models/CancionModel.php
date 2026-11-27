<?php

namespace App\Models;

use CodeIgniter\Model;

class CancionModel extends Model
{
    protected $table         = 'canciones';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['titulo', 'archivo_audio', 'id_artista', 'id_genero'];

    // Canciones con su artista y género, con filtros opcionales (Query Builder)
    public function conDetalle(string $q = '', string $genero = ''): array
    {
        $builder = $this->db->table('canciones c')
            ->select('c.id, c.titulo, c.archivo_audio, a.nombre AS artista, g.nombre AS genero')
            ->join('artistas a', 'c.id_artista = a.id')
            ->join('generos g', 'c.id_genero = g.id');

        if ($q !== '') {
            $builder->groupStart()
                        ->like('c.titulo', $q)
                        ->orLike('a.nombre', $q)
                    ->groupEnd();
        }
        if ($genero !== '') {
            $builder->where('g.nombre', $genero);
        }

        return $builder->orderBy('c.titulo', 'ASC')->get()->getResultArray();
    }
}