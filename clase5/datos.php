<?php
// Funciones y datos compartidos por los formularios de la clase 5.

function limpiar(string $valor): string
{
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}

$catalogo = [
    ['id' => 'pop1',         'titulo' => 'Barcelona',            'artista' => 'vibemode',        'genero' => 'Pop'],
    ['id' => 'pop2',         'titulo' => 'Pop Music',            'artista' => 'prettyjohn1',     'genero' => 'Pop'],
    ['id' => 'rock1',        'titulo' => 'Rock Music',           'artista' => 'jonasblakewood',  'genero' => 'Rock'],
    ['id' => 'rock2',        'titulo' => 'Dirty Rock',           'artista' => 'kulakovka',       'genero' => 'Rock'],
    ['id' => 'indie1',       'titulo' => 'Summer Walk',          'artista' => 'folk_acoustic',   'genero' => 'Indie'],
    ['id' => 'indie2',       'titulo' => 'Indie Folk',           'artista' => 'jonasblakewood',  'genero' => 'Indie'],
    ['id' => 'hiphop1',      'titulo' => 'Hip Hop Beat',         'artista' => 'vaitsez',         'genero' => 'Hip-Hop'],
    ['id' => 'hiphop2',      'titulo' => 'Hip Hop Groove',       'artista' => 'prettyjohn1',     'genero' => 'Hip-Hop'],
    ['id' => 'electronica1', 'titulo' => 'Abstract Electronica', 'artista' => 'arpmedia',        'genero' => 'Electrónica'],
    ['id' => 'electronica2', 'titulo' => 'Retrowave',            'artista' => 'the_mountain',    'genero' => 'Electrónica'],
    ['id' => 'metal1',       'titulo' => 'Thrash Metal',         'artista' => 'alex-morgan',     'genero' => 'Metal'],
    ['id' => 'metal2',       'titulo' => 'Metal Music',          'artista' => 'jonasblakewood',  'genero' => 'Metal'],
];