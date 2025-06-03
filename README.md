Mu-Plugin - Lista de URLs de Vimeo con Contador
=============================================

Descripción:
-------------
Este mu-plugin (Must-Use Plugin) para WordPress busca en el contenido de publicaciones (posts) y páginas todas las URLs de Vimeo que cumplan con alguno de los siguientes formatos:
 - URLs tradicionales con ID numérico: https://vimeo.com/123456789
 - URLs personalizadas que incluyen el segmento "blogpocket": https://vimeo.com/blogpocket/alguna-cosa

El plugin genera un array de resultados sin duplicados por post, ordena las URLs alfabéticamente y muestra la lista mediante un shortcode en forma de tabla con las siguientes columnas:
 1. Contador: Numeración creciente de cada URL encontrada.
 2. URL de Vimeo: La URL del vídeo encontrada.
 3. Título del Post: Título de la publicación o página donde aparece la URL.
 4. URL del Post: Enlace permanente (permalink) a la publicación o página.

Instrucciones de instalación:
-----------------------------
1. Copia este archivo ZIP (vimeo_mu_plugin.zip) en tu equipo local.
2. Descomprime el archivo ZIP para obtener la carpeta "vimeo-mu-plugin" que contiene:
   - vimeo-posts-list.php
   - readme.txt
3. Accede a la carpeta de tu instalación de WordPress, luego navega hasta `wp-content/mu-plugins`.
   - Si la carpeta "mu-plugins" no existe, créala.
4. Copia el archivo `vimeo-posts-list.php` dentro de `wp-content/mu-plugins`.
   - No es necesario activar el plugin desde el panel de Administración, ya que los mu-plugins se cargan automáticamente.
5. (Opcional) Coloca el archivo `readme.txt` en la misma carpeta o mantenlo en tu equipo para referencia.

Uso del shortcode:
------------------
Para mostrar la lista de URLs de Vimeo en una página o entrada de WordPress, inserta el siguiente shortcode en el contenido:
```
[vimeo_posts_list]
```

Al publicar o actualizar la página/entrada, se mostrará una tabla con todas las URLs de Vimeo encontradas, junto con el título y el enlace al post correspondiente.

Notas adicionales:
------------------
- Este plugin no requiere activación manual: basta con copiar el archivo PHP en la carpeta `mu-plugins`.
- Si deseas modificar estilos o estructura de la tabla, puedes editar directamente el archivo `vimeo-posts-list.php`.
- Asegúrate de tener permisos adecuados para escribir en la carpeta `wp-content/mu-plugins`.

¡Listo! Ahora tendrás disponible este mu-plugin para listar las URLs de Vimeo en WordPress.
