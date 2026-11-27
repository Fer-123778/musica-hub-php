# Música Hub

Sitio web de música donde la comunidad descubre canciones, vota con estrellas y consulta rankings, géneros, noticias y giras. En esta etapa (Unidad 4) la maqueta estática se migró a *PHP, se modularizó con **Server Side Includes (SSI)* y se agregaron títulos dinámicos y variables de entorno (.env).

## Prototipo en Figma
https://twice-satin-42519228.figma.site/

## Tecnologías utilizadas
- HTML5, CSS3 y Bootstrap 5
- JavaScript
- PHP 8.x
- XAMPP (Apache) como servidor local
- Git y GitHub

## Estructura del proyecto
- includes/header.php: etiquetas <head>, metadatos, hojas de estilo y título dinámico.
- includes/nav.php: menú de navegación con la clase active en la sección actual.
- includes/footer.php: pie de página y scripts de JavaScript.
- config/config.php: lee el archivo .env y define las constantes del sitio.
- .env.example: plantilla de las variables de entorno.

## Instalación y ejecución local
1. Instalar XAMPP e iniciar *Apache* desde el panel de control.
2. Clonar el repositorio dentro de C:\xampp\htdocs:
   git clone https://github.com/Fer-123778/musica-hub-php.git
3. Copiar .env.example y renombrar la copia como .env.
4. Abrir en el navegador: http://localhost/musica-hub-php/

## Evidencia de funcionamiento

### Servidor local ejecutándose
![Servidor local](capturas/capturas/01-servidor-local.png)

### Estructura modular (SSI)
![Estructura SSI](capturas/capturas/02-estructura-ssi.png)

### Navegación dinámica (título y menú activo)
![Navegación dinámica](capturas/capturas/03-navegador-dinamica.png)

### Variables de entorno
![Archivo .env.example](capturas/capturas/04-env-example.png)

## Clase 5: Procesamiento de formularios y seguridad web

Todo el desarrollo de esta entrega está en la carpeta clase5/.

### Formulario POST: opiniones (clase5/opiniones.php)
Formulario con nombre, email y opinión. El servidor valida que ningún campo llegue vacío, que el nombre tenga al menos 2 caracteres, que el email tenga un formato válido (filter_var) y que la opinión tenga al menos 10 caracteres. Si hay errores, muestra mensajes y conserva los datos escritos. Si todo es correcto, muestra un mensaje de éxito.

### Formulario GET: buscador (clase5/buscar.php)
Buscador de canciones y artistas por texto y género. Los datos viajan en la URL (por ejemplo buscar.php?q=rock&genero=). Valida que se complete al menos un campo, limita el texto a 50 caracteres y acepta solo géneros de una lista permitida.

### Seguridad (prevención de XSS)
- trim() para quitar espacios sobrantes.
- htmlspecialchars() en la función limpiar() (clase5/datos.php), aplicada a todo dato del usuario antes de mostrarlo.
- filter_var() con FILTER_VALIDATE_EMAIL para el email.
- Lista blanca de géneros en el buscador.

### Capturas de pantalla

*Opiniones con errores de validación* (los campos se conservan)
![Opiniones con errores](clase5/capturas/01-opiniones-error.png)

*Opiniones enviada con éxito*
![Opiniones exitosa](clase5/capturas/02-opiniones-exito.png)

*Prueba de seguridad XSS* (el script se muestra como texto y no se ejecuta)
![Prueba XSS](clase5/capturas/03-opiniones-xss.png)

*Búsqueda con resultados* (método GET)
![Búsqueda con resultados](clase5/capturas/04-buscar-resultados.png)

*Búsqueda con error de validación*
![Búsqueda con error](clase5/capturas/05-buscar-error.png)

## TP 6: Diseño y creación del esquema relacional en MySQL

Todo el desarrollo está en la carpeta tp6/.

- tp6/NORMALIZACION.md: tabla sin normalizar, 1FN, 2FN, 3FN y lista de tablas con sus PK y FK.
- tp6/schema.sql: crea la base musica_hub con 7 tablas, claves primarias y foráneas, campos de auditoría e índices.
- tp6/consultas.sql: inserciones, consultas con WHERE, ORDER BY e INNER JOIN, un UPDATE y un DELETE.

### Capturas de pantalla

*Tablas creadas en phpMyAdmin*
![Tablas](tp6/capturas/01-tablas.png)

*Consulta con INNER JOIN*
![Consulta JOIN](tp6/capturas/02-join.png)

## TP 7: Persistencia y conexión PHP-MySQL segura

Módulo CRUD de canciones integrado al sitio, en la carpeta admin/. Usa la base musica_hub del TP 6.

- config/conexion.php: conexión PDO con try-catch. Los datos de conexión se leen del archivo .env.
- admin/index.php: listado de canciones (Read) con INNER JOIN a artistas y géneros.
- admin/crear.php: alta de canciones (Create).
- admin/editar.php: modificación de canciones (Update).
- admin/eliminar.php: baja de canciones (Delete).

### Seguridad
- Todas las consultas usan *sentencias preparadas* con parámetros nombrados (:titulo, :id, etc.) para evitar inyección SQL.
- Toda variable impresa en pantalla pasa por htmlspecialchars() (función h()) para evitar XSS.
- Validación en el servidor: campos obligatorios y filter_var para los identificadores.

### Capturas de pantalla

*Listado de canciones (Read)*
![Listado](tp7/capturas/01-listado.png)

*Formulario de alta con errores de validación (Create)*
![Crear](tp7/capturas/02-crear.png)

*Formulario de edición (Update)*
![Editar](tp7/capturas/03-editar.png)

*Eliminación de un registro (Delete)*
![Eliminado](tp7/capturas/04-eliminado.png)

*Datos reflejados en MySQL (phpMyAdmin)*
![Base de datos](tp7/capturas/05-base.png)

## TP 8: Manejo de estado, sesiones y autenticación

Módulo de registro, inicio y cierre de sesión integrado al sitio.

- registro.php: alta de usuarios con validación, verificación de email único y contraseña con password_hash(..., PASSWORD_BCRYPT).
- login.php: valida credenciales con password_verify(), ejecuta session_regenerate_id(true) y guarda usuario_id, usuario_nombre y rol en $_SESSION.
- includes/auth_guard.php: guardián de rutas. Si no hay sesión, redirige a login.php?error=acceso_denegado. Incluye control por rol.
- panel.php: página protegida para cualquier usuario autenticado.
- admin_panel.php: página protegida solo para el rol admin.
- admin/: el CRUD de canciones también exige sesión iniciada.
- logout.php: vacía $_SESSION, elimina la cookie de sesión y ejecuta session_destroy().

### Seguridad
- Contraseñas guardadas como hash bcrypt, nunca en texto plano.
- Consultas preparadas con PDO en todas las operaciones.
- htmlspecialchars() en todo dato impreso.
- Regeneración del identificador de sesión al iniciar sesión (previene fijación de sesión).

### Capturas de pantalla

*Registro con error de validación*
![Registro](tp8/capturas/01-registro.png)

*Login con credenciales incorrectas*
![Login con error](tp8/capturas/02-login-error.png)

*Acceso denegado sin sesión*
![Acceso denegado](tp8/capturas/03-acceso-denegado.png)

*Panel del usuario autenticado*
![Panel](tp8/capturas/04-panel.png)

*Panel de administración (rol admin)*
![Panel admin](tp8/capturas/05-admin-panel.png)

*Usuario común sin permisos para el panel de administración*
![Sin permiso](tp8/capturas/06-sin-permiso.png)

*Contraseña guardada como hash en la base de datos*
![Hash en la base](tp8/capturas/07-hash-base.png)

## TP 9: Comunicación asincrónica y APIs (AJAX y JSON)

Búsqueda de canciones en vivo, sin recargar la página.

- api/buscar_canciones.php: endpoint PHP que consulta MySQL con PDO y consultas preparadas, y responde en formato JSON (json_encode). Devuelve los códigos HTTP 200 (resultados), 400 (búsqueda inválida), 404 (sin resultados), 405 (método no permitido) y 500 (error de base de datos).
- buscador.php: página con el cuadro de búsqueda y el contenedor de resultados.
- js/main.js: captura el evento input, hace la petición con fetch (async/await), maneja errores con try...catch y construye las tarjetas en el DOM sin recargar.

### Seguridad
- Consultas preparadas con parámetros nombrados.
- Los comodines del LIKE se escapan con addcslashes.
- Largo máximo de búsqueda validado en el servidor.
- Los resultados se insertan con textContent y no con innerHTML, para evitar XSS.

### Diferencia con la búsqueda del TP 5
La búsqueda del TP 5 (clase5/buscar.php) envía un formulario GET y recarga la página. El buscador en vivo actualiza solo la sección de resultados.

### Capturas de pantalla

*Respuesta JSON del endpoint*
![JSON](tp9/capturas/01-json-todas.png)

*Buscador al abrir*
![Buscador inicio](tp9/capturas/02-buscador-inicio.png)

*Búsqueda "rock" sin recargar la página*
![Buscador rock](tp9/capturas/03-buscador-rock.png)

*Búsqueda sin resultados*
![Sin resultados](tp9/capturas/04-sin-resultados.png)

*Códigos de estado HTTP en la pestaña Red*
![Códigos HTTP](tp9/capturas/05-codigos-http.png)

## TP 10: Refactorización a MVC e implementación con framework

### Parte A: MVC en PHP puro
El CRUD de canciones se reorganizó en app/Models/, app/Views/ y app/Controllers/, con canciones.php como punto de entrada.
- app/Models/Cancion.php: consultas SQL con PDO y sentencias preparadas.
- app/Controllers/CancionController.php: recibe la petición, valida y elige la vista.
- app/Views/canciones/: marcado HTML sin lógica de base de datos.

![Listado MVC](tp10/capturas/01-mvc-listado.png)
![Formulario MVC](tp10/capturas/02-mvc-formulario.png)
![Estructura MVC](tp10/capturas/03-mvc-estructura.png)

### Parte B: módulo con CodeIgniter 4
Proyecto de CodeIgniter 4 (instalación manual) en la carpeta ci4/. Módulo de canciones:
- Rutas: canciones-ci y api/canciones (ci4/app/Config/Routes.php).
- Controlador: ci4/app/Controllers/Canciones.php.
- Modelo con Query Builder: ci4/app/Models/CancionModel.php.
- Vistas con el motor de plantillas del framework: ci4/app/Views/layout.php y ci4/app/Views/canciones/lista.php.
- La API devuelve JSON con los códigos 200, 400 y 404.

Para ejecutarlo: copiar ci4/env como ci4/.env y completar los datos de la base (host, base musica_hub, usuario y puerto 3307).

![Listado CodeIgniter](tp10/capturas/04-ci-listado.png)
![API JSON](tp10/capturas/05-ci-api-json.png)
![Estructura CodeIgniter](tp10/capturas/06-ci-estructura.png)