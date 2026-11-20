USE musica_hub;

-- CREATE: tablas maestras
INSERT INTO roles (nombre) VALUES ('administrador'), ('usuario');
INSERT INTO generos (nombre) VALUES ('Rock'), ('Pop'), ('Indie'), ('Hip-Hop'), ('Electrónica'), ('Metal');
INSERT INTO artistas (nombre) VALUES ('jonasblakewood'), ('vibemode'), ('kulakovka'), ('prettyjohn1');

-- CREATE: usuarios, canciones y votos
INSERT INTO usuarios (nombre, email, password, id_rol) VALUES
    ('Fernando Aramayo', 'fernando@ejemplo.com', 'hash_de_prueba_1', 1),
    ('Lucía Gómez', 'lucia@ejemplo.com', 'hash_de_prueba_2', 2);

INSERT INTO canciones (titulo, archivo_audio, id_artista, id_genero) VALUES
    ('Rock Music', 'rock1.mp3', 1, 1),
    ('Dirty Rock', 'rock2.mp3', 3, 1),
    ('Barcelona', 'pop1.mp3', 2, 2),
    ('Pop Music', 'pop2.mp3', 4, 2);

INSERT INTO votos (id_usuario, id_cancion) VALUES (1, 1), (2, 1), (2, 3);

-- READ: filtrar y ordenar
SELECT id, titulo, archivo_audio
FROM canciones
WHERE id_genero = 1
ORDER BY titulo ASC;

-- READ: INNER JOIN de cuatro tablas
SELECT c.titulo, a.nombre AS artista, g.nombre AS genero, COUNT(v.id_usuario) AS estrellas
FROM canciones c
INNER JOIN artistas a ON c.id_artista = a.id
INNER JOIN generos g ON c.id_genero = g.id
LEFT JOIN votos v ON v.id_cancion = c.id
GROUP BY c.id, c.titulo, a.nombre, g.nombre
ORDER BY estrellas DESC;

-- UPDATE: modificar un registro
UPDATE canciones
SET titulo = 'Rock Music (Remix)'
WHERE id = 1;

-- DELETE: dar de baja un registro de prueba
DELETE FROM votos
WHERE id_usuario = 2 AND id_cancion = 3;