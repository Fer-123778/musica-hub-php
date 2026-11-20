# Normalización de la base de datos de Música Hub

## Parte 1: tabla sin normalizar

Registro hipotético de una canción con sus votantes y géneros en una sola tabla:

| id | titulo | artista | email_artista | generos | usuarios_que_votaron |
|----|--------|---------|---------------|---------|----------------------|
| 1 | Rock Music | jonasblakewood | contacto@jonas.com | Rock, Indie | fernando@ejemplo.com, lucia@ejemplo.com |

Problemas:
- Los campos generos y usuarios_que_votaron guardan varios valores en una sola celda (campos multivalorados).
- Los datos del artista se repiten en cada canción (redundancia).

## 1FN: valores atómicos

Cada celda tiene un solo valor, y cada voto o género pasa a una fila propia:

| id_cancion | titulo | artista | email_artista | genero | usuario |
|------------|--------|---------|---------------|--------|---------|
| 1 | Rock Music | jonasblakewood | contacto@jonas.com | Rock | fernando@ejemplo.com |
| 1 | Rock Music | jonasblakewood | contacto@jonas.com | Rock | lucia@ejemplo.com |

La clave compuesta pasa a ser (id_cancion, usuario).

## 2FN: eliminar dependencias parciales

titulo, artista, email_artista y genero dependen solo de id_cancion, y no de la clave completa. Se separan:

- canciones(id, titulo, artista, email_artista, genero)
- votos(id_cancion, id_usuario)

## 3FN: eliminar dependencias transitivas

email_artista depende de artista, que no es clave: es una dependencia transitiva. Lo mismo pasa con el nombre del género y el rol del usuario. Se extraen a tablas propias:

- artistas(id, nombre)
- generos(id, nombre)
- roles(id, nombre)

## Tablas resultantes

| Tabla | Clave primaria (PK) | Claves foráneas (FK) |
|-------|---------------------|----------------------|
| roles | id | |
| generos | id | |
| artistas | id | |
| usuarios | id | id_rol -> roles(id) |
| canciones | id | id_artista -> artistas(id), id_genero -> generos(id) |
| votos | (id_usuario, id_cancion) | id_usuario -> usuarios(id), id_cancion -> canciones(id) |
| opiniones | id | |

La tabla votos resuelve la relación muchos a muchos entre usuarios y canciones.