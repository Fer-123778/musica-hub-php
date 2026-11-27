<?php
class Cancion
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function todas(): array
    {
        $sql = "SELECT c.id, c.titulo, c.archivo_audio, a.nombre AS artista, g.nombre AS genero
                FROM canciones c
                INNER JOIN artistas a ON c.id_artista = a.id
                INNER JOIN generos g ON c.id_genero = g.id
                ORDER BY c.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM canciones WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        return $fila ?: null;
    }

    public function artistas(): array
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM artistas ORDER BY nombre");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function generos(): array
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM generos ORDER BY nombre");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crear(array $d): void
    {
        $sql = "INSERT INTO canciones (titulo, archivo_audio, id_artista, id_genero)
                VALUES (:titulo, :archivo_audio, :id_artista, :id_genero)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $d['titulo'],
            ':archivo_audio' => $d['archivo_audio'],
            ':id_artista' => (int) $d['id_artista'],
            ':id_genero' => (int) $d['id_genero'],
        ]);
    }

    public function actualizar(int $id, array $d): void
    {
        $sql = "UPDATE canciones
                SET titulo = :titulo, archivo_audio = :archivo_audio,
                    id_artista = :id_artista, id_genero = :id_genero
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $d['titulo'],
            ':archivo_audio' => $d['archivo_audio'],
            ':id_artista' => (int) $d['id_artista'],
            ':id_genero' => (int) $d['id_genero'],
            ':id' => $id,
        ]);
    }

    public function eliminar(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM canciones WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}