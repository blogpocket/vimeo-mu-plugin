<?php
/**
 * Plugin Name: Mu-Plugin - Lista de URLs de Vimeo con Contador
 * Description: Mu-plugin para listar todas las URLs de Vimeo presentes en posts y páginas, mostrando un contador, URL de Vimeo, Título y URL del Post, sin duplicados por post.
 * Version: 1.3
 * Author: Tu Nombre
 */
// Define el segmento personalizado de Vimeo que se utilizará para URLs del tipo https://vimeo.com/<segmento>/...
// Por defecto: 'blogpocket'. Cambia este valor según tu configuración.
if (!defined('VIMEO_CUSTOM_SEGMENT')) {
    define('VIMEO_CUSTOM_SEGMENT', 'blogpocket');
}
// Función para obtener el array de posts/páginas con todas las URLs de Vimeo encontradas
function get_vimeo_posts_array() {
    global $wpdb;
    $segment = VIMEO_CUSTOM_SEGMENT;
    // Actualizamos la consulta REGEXP para que encuentre tanto URLs con dígitos como aquellas con el segmento "blogpocket"
    // Nota: En MySQL usamos [^[:space:]]+ para indicar "uno o más caracteres que no sean espacios"
    $query = "
        SELECT ID, post_title, post_content 
        FROM $wpdb->posts 
        WHERE post_status = 'publish'
          AND post_type IN ('post','page')
          AND post_content REGEXP 'https://vimeo\\\\.com/([0-9]+|$segment/[^[:space:]]+)'
    ";
    
    $results = $wpdb->get_results($query);
    $posts_with_vimeo = array();
    
    if ($results) {
        foreach ($results as $post) {
            // Utilizamos preg_match_all con una expresión regular que capture ambas variantes:
            // - URLs con solo números: https://vimeo.com/123456789
            // - URLs con "blogpocket": https://vimeo.com/$segment/alguna-cosa
            if (preg_match_all('/https:\/\/vimeo\.com\/(?:[0-9]+|blogpocket\/[^\s"\'<>]+)/', $post->post_content, $matches)) {
                // Filtramos duplicados en el mismo post
                $unique_vimeo_urls = array_unique($matches[0]);
                foreach ($unique_vimeo_urls as $vimeo_url) {
                    $posts_with_vimeo[] = array(
                        'vimeo_url' => $vimeo_url,
                        'title'     => $post->post_title,
                        'permalink' => get_permalink($post->ID)
                    );
                }
            }
        }
    }
    
    // Ordenar el array alfabéticamente por la URL de Vimeo
    usort($posts_with_vimeo, function($a, $b) {
        return strcmp($a['vimeo_url'], $b['vimeo_url']);
    });
    
    return $posts_with_vimeo;
}

// Función para mostrar los resultados mediante un shortcode
function display_vimeo_posts_list() {
    $posts = get_vimeo_posts_array();
    
    if (!empty($posts)) {
        // Construimos la tabla de salida con columnas: Contador, URL de Vimeo, Título del Post y URL del Post
        $output  = '<table style="width:100%; border-collapse: collapse;" border="1" cellspacing="0" cellpadding="5">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>Contador</th>';
        $output .= '<th>URL de Vimeo</th>';
        $output .= '<th>Título del Post</th>';
        $output .= '<th>URL del Post</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
        
        $counter = 1;
        foreach ($posts as $post) {
            $vimeo_url = esc_url($post['vimeo_url']);
            $title     = esc_html($post['title']);
            $permalink = esc_url($post['permalink']);
            
            $output .= '<tr>';
            $output .= "<td>{$counter}</td>";
            $output .= "<td><a href='{$vimeo_url}' target='_blank'>{$vimeo_url}</a></td>";
            $output .= "<td>{$title}</td>";
            $output .= "<td><a href='{$permalink}' target='_blank'>{$permalink}</a></td>";
            $output .= '</tr>';
            
            $counter++;
        }
        
        $output .= '</tbody>';
        $output .= '</table>';
    } else {
        $output = 'No se encontraron posts o páginas con URLs de Vimeo.';
    }
    
    return $output;
}

// Crear el shortcode para usarlo en el sitio: [vimeo_posts_list]
add_shortcode('vimeo_posts_list', 'display_vimeo_posts_list');
