<?php

/**
 * Theme filters.
 */

namespace App;
use Illuminate\Support\Str;
/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
// excerpt_more should be set the empty.
add_filter( 'excerpt_more', '__return_empty_string', 21 );

function wpse_134143_excerpt_more_link( $excerpt ) {
    $excerpt .= sprintf('<a class="group no-underline mt-4 inline-flex items-center text-sm text-gray-600  hover:text-gray-900 dark:text-gray-200 dark:hover:text-gray-100" href="%s">%s <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-1 h-4 w-4 transition-transform group-hover:translate-x-0.5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></a>', 
    get_permalink(), 
    __('Read article', 'sage')
    );

    return $excerpt;
}
// Utilisez la constante magique __NAMESPACE__ pour plus de sécurité
add_filter( 'the_excerpt', __NAMESPACE__ . '\\wpse_134143_excerpt_more_link', 21 );

/**
 * Get post reading time with pluralization.
 */
function reading_time($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field('post_content', $post_id);
    
    // Fallback if content is empty
    if (empty(strip_tags($content))) {
        return '0 minute';
    }

    $word_count = Str::wordCount(strip_tags($content));
    $minutes = ceil($word_count / 200);

    // If minutes is 1, use 'min', otherwise use 'mins'
    $suffix = ($minutes == 1) ? 'minute' : 'minutes';

    return "{$minutes} {$suffix}";
}

add_filter('wp_list_comments_args', function ($args) {
    $args['callback'] = function ($comment, $args, $depth) {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        echo view('partials.comment-simple', ['comment' => $comment, 'args' => $args, 'depth' => $depth, 'tag' => $tag])->render();
    };
    return $args;
});

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});
// On accepte un argument $format qui vaut 'list' par défaut
add_action('custom_tag_list', function ($format = 'list') {
    $tagController = new \App\Controllers\TagController(new \App\Models\TagModel());
    echo $tagController->renderTagList($format);
}, 10, 1);

add_action('wp_head', ['App\Controllers\TagController', 'no_index_lowtags']);

add_filter( 'wpseo_breadcrumb_links', 'App\force_real_category_breadcrumb' );

function force_real_category_breadcrumb( $links ) {
    // On n'agit que sur les articles seuls
    if ( is_singular( 'post' ) ) {
        $categories = get_the_category();

        if ( ! empty( $categories ) ) {
            // On récupère la catégorie (la première, puisqu'il n'y en a qu'une)
            $main_cat = $categories[0];
            
            // On prépare le nouveau lien
            $new_link = array(
                'url'  => get_term_link( $main_cat ),
                'text' => $main_cat->name,
            );

            // On cherche si un lien erroné (index 1) existe déjà pour le remplacer
            // Sinon on l'insère entre Accueil (0) et l'Article (2)
            if ( count( $links ) >= 2 ) {
                // Remplacement du niveau 1 (souvent là où se trouve le "rated-1")
                $links[1] = $new_link;
            } else {
                // Insertion si le tableau est trop court
                array_splice( $links, 1, 0, array( $new_link ) );
            }
        }
    }
    return $links;
}

/**
 * Vanilla JS Lightbox data attribute to image links
 */
add_filter('the_content', function ($content) {
    // On ne cible que les liens pointant directement vers des images (jpg, jpeg, png, gif, webp)
    $pattern = '/<a(.*?)href=["\']([^"\']+\.(?:jpe?g|png|gif|webp))["\']([^>]*)>/i';
    
    // On remplace pour ajouter data-fslightbox
    $replacement = '<a$1href="$2"$3 data-fslightbox="gallery">';
    
    $content = preg_replace($pattern, $replacement, $content);
    
    return $content;
}, 10);

/**
 * Custom search form
 */
add_filter('get_search_form', function ($form) {
    ob_start();
    echo view('partials.searchform')->render();
    return ob_get_clean();
});
/**
 * Register a custom REST API endpoint to fetch random tags.
 */
function register_random_tags_endpoint() {
    register_rest_route('custom/v1', '/random-tags', array(
        'methods' => 'GET',
        'callback' => 'App\\get_random_tags',
                'permission_callback' => '__return_true', // Add permission_callback for public access

    ));
}

add_action('rest_api_init', 'App\register_random_tags_endpoint');

/**
 * Callback function to fetch random tags.
 */
function get_random_tags($request) {
    // Number of tags to fetch randomly
    $num_tags = isset($request['number']) ? intval($request['number']) : 3;

    // Get all tags
    $tags = get_terms(array(
        'taxonomy' => 'post_tag',
        'hide_empty' => false,
    ));

    // Check if there are tags
    if (empty($tags) || is_wp_error($tags)) {
        return new WP_Error('no_tags', 'No tags found', array('status' => 404));
    }

    // Shuffle the tags array to get random tags
    shuffle($tags);

    // Get the specified number of random tags
    $random_tags = array_slice($tags, 0, $num_tags);

    // Prepare the response
    $response = array();
    foreach ($random_tags as $tag) {
        $response[] = array(
            'id' => $tag->term_id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'count' => $tag->count,
        );
    }


    return rest_ensure_response($response);
}