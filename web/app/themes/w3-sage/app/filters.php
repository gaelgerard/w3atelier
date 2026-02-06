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
// Custom tag list
use App\Controllers\TagController;

add_action('custom_tag_list', function () {
    $tagController = new TagController(new \App\Models\TagModel());
    echo $tagController->renderTagList();
});
