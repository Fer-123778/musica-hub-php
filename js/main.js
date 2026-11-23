document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('inputBusqueda');
    const formBusqueda = document.getElementById('formBusqueda');
    const contenedor = document.getElementById('resultados');
    const estado = document.getElementById('estadoBusqueda');

    // Solo corre en la página del buscador
    if (!inputBusqueda) {
        return;
    }

    let temporizador = null;

    // Evita recargar la página al apretar Enter
    formBusqueda.addEventListener('submit', (e) => {
        e.preventDefault();
        buscar(inputBusqueda.value.trim());
    });

    // Busca mientras el usuario escribe (espera 300 ms para no saturar el servidor)
    inputBusqueda.addEventListener('input', (e) => {
        clearTimeout(temporizador);
        const texto = e.target.value.trim();
        temporizador = setTimeout(() => buscar(texto), 300);
    });

    async function buscar(texto) {
        estado.textContent = 'Buscando...';
        try {
            const respuesta = await fetch(
                'api/buscar_canciones.php?q=' + encodeURIComponent(texto)
            );

            // 404 = sin resultados: el servidor devuelve JSON igual
            if (!respuesta.ok && respuesta.status !== 404) {
                throw new Error('Error HTTP: ' + respuesta.status);
            }

            const datos = await respuesta.json();

            if (datos.status === 'success') {
                estado.textContent = datos.total + ' resultado(s).';
                dibujar(datos.data);
            } else if (datos.status === 'not_found') {
                estado.textContent = '';
                contenedor.innerHTML = '';
                mostrarMensaje('No se encontraron canciones para "' + texto + '".');
            } else {
                throw new Error(datos.message || 'Respuesta inesperada.');
            }
        } catch (error) {
            console.error('Error al realizar la petición:', error);
            estado.textContent = '';
            contenedor.innerHTML = '';
            mostrarMensaje('No se pudo completar la búsqueda. Probá de nuevo.');
        }
    }

    function mostrarMensaje(texto) {
        const aviso = document.createElement('div');
        aviso.className = 'alert alert-warning';
        aviso.setAttribute('role', 'alert');
        aviso.textContent = texto;
        contenedor.appendChild(aviso);
    }

    // Construye las tarjetas con textContent (no innerHTML): evita XSS
    function dibujar(canciones) {
        contenedor.innerHTML = '';
        canciones.forEach((c) => {
            const tarjeta = document.createElement('div');
            tarjeta.className = 'tarjeta mb-3';

            const titulo = document.createElement('h2');
            titulo.className = 'h5';
            titulo.textContent = c.titulo;

            const detalle = document.createElement('p');
            detalle.className = 'texto-suave mb-2';
            detalle.textContent = c.artista + ' · ' + c.genero + ' · ⭐ ' + c.estrellas;

            const audio = document.createElement('audio');
            audio.controls = true;
            audio.className = 'w-100';
            audio.preload = 'none';
            audio.src = 'audio/' + encodeURIComponent(c.archivo_audio);

            tarjeta.append(titulo, detalle, audio);
            contenedor.appendChild(tarjeta);
        });
    }

    // Carga inicial: muestra todas las canciones
    buscar('');
});