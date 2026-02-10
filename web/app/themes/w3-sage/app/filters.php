<?php

/**
 * Theme filters.
 */

namespace App;

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

/**
 * Force la catégorie dans le fil d'Ariane de Yoast SEO
 *
 * @param array $links Les liens du fil d'Ariane.
 * @return array Les liens modifiés.
 */
add_filter( 'wpseo_breadcrumb_links', 'App\clean_and_fix_yoast_breadcrumbs' );

function clean_and_fix_yoast_breadcrumbs( $links ) {
    // On ne cible que les articles seuls
    if ( is_singular( 'post' ) ) {
        
        $post_id = get_the_ID();
        $primary_cat_id = get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
        
        // Si pas de catégorie primaire définie par Yoast, on prend la première
        if ( ! $primary_cat_id ) {
            $categories = get_the_category( $post_id );
            if ( ! empty( $categories ) ) {
                $primary_cat_id = $categories[0]->term_id;
            }
        }

        if ( $primary_cat_id ) {
            $category = get_term( $primary_cat_id );

            // Si le fil d'ariane n'a que 2 niveaux (Accueil > Article), on insère la catégorie
            if ( count( $links ) <= 2 ) {
                $category_link = array(
                    'url'  => get_term_link( $category ),
                    'text' => $category->name,
                );
                array_splice( $links, 1, 0, array( $category_link ) );
            } 
            // Si la catégorie est présente mais s'appelle "rated-1", on corrige le texte
            else {
                foreach ( $links as $key => $link ) {
                    if ( isset($link['text']) && (strpos($link['text'], 'rated') !== false || empty($link['text'])) ) {
                        $links[$key]['text'] = $category->name;
                        $links[$key]['url']  = get_term_link( $category );
                    }
                }
            }
        }
    }
    return $links;
}