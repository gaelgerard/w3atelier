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

// Source - https://stackoverflow.com/a/19798621
// Posted by dmontooth
// Retrieved 2026-01-31, License - CC BY-SA 3.0

function modify_comment_fields($defaults) {

    $commenter = wp_get_current_commenter();
    $req       = get_option('require_name_email');
    $aria_req  = $req ? "aria-required='true'" : '';

    $input_base = 'w-full border-b border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-0';
    $label_base = 'block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100';

    $defaults['class_form'] = 'space-y-6';
    $defaults['class_submit'] = 'inline-flex items-center rounded-md bg-gray-900 dark:bg-gray-100 px-5 py-2.5 text-sm font-medium text-white dark:text-gray-900 hover:bg-gray-800 dark:hover:text-gray-100 cursor-pointer focus:outline-none';

    $defaults['comment_field'] = '
    <div>
        <label for="comment" class="' . $label_base . '">
            Commentaire
        </label>
        <textarea
            id="comment"
            name="comment"
            rows="5"
            class="' . $input_base . '"
            placeholder="Votre commentaire…"
            required
        ></textarea>
    </div>';

    $defaults['fields'] = [
        'author' => '
        <div>
            <label for="author" class="' . $label_base . '">
                Nom' . ($req ? ' *' : '') . '
            </label>
            <input
                id="author"
                name="author"
                type="text"
                value="' . esc_attr($commenter['comment_author']) . '"
                class="' . $input_base . '"
                ' . $aria_req . '
            />
        </div>',

        'email' => '
        <div>
            <label for="email" class="' . $label_base . '">
                Email' . ($req ? ' *' : '') . '
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="' . esc_attr($commenter['comment_author_email']) . '"
                class="' . $input_base . '"
                ' . $aria_req . '
            />
        </div>',

        'url' => '
        <div>
            <label for="url" class="' . $label_base . '">
                Site web
            </label>
            <input
                id="url"
                name="url"
                type="url"
                value="' . esc_attr($commenter['comment_author_url']) . '"
                class="' . $input_base . '"
            />
        </div>',
    ];

    $defaults['title_reply'] = 'Laisser un commentaire';
    $defaults['title_reply_before'] = '<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-4">';
    $defaults['title_reply_after']  = '</h3>';

    $defaults['comment_notes_before'] = '';
    $defaults['comment_notes_after'] = '
        <p class="text-sm text-gray-500">
            Votre adresse email ne sera pas publiée. Les champs marqués d’un * sont obligatoires
        </p>';

    return $defaults;
};

add_filter('comment_form_defaults', __NAMESPACE__ . '\\modify_comment_fields');

function sage_comment_callback($comment, $args, $depth)
{
    $tag = ($args['style'] === 'div') ? 'div' : 'li';
    ?>

    <<?php echo $tag; ?> <?php comment_class('group'); ?> id="comment-<?php comment_ID(); ?>">

        <article class="flex gap-4 py-6">


            <!-- Contenu -->
            <div class="flex-1">

                <header class="flex flex-wrap items-center gap-x-2 text-sm text-gray-700">
                    
            <!-- Avatar -->
            <div class="shrink-0">
                <?php echo get_avatar($comment, 40, '', '', [
                    'class' => 'rounded-full',
                ]); ?>
            </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        <?php comment_author(); ?>
                    </span>

                    <span class="text-gray-400">·</span>

                    <time datetime="<?php comment_time('c'); ?>" class="text-gray-500">
                        <?php comment_date(); ?>
                    </time>
                </header>

                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="mt-2 text-sm text-amber-600">
                        Votre commentaire est en attente de modération.
                    </p>
                <?php endif; ?>

                <div class="prose prose-sm mt-3 max-w-none">
                    <?php comment_text(); ?>
                </div>

                <footer class="mt-3 text-sm text-gray-500">
                    <?php
                    comment_reply_link(array_merge($args, [
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => 'Répondre',
                    ]));
                    ?>
                </footer>

            </div>
        </article>

    <?php
    error_log('sage_comment called');
}

add_filter('wp_list_comments_args', function ($args) {
    $args['callback'] = __NAMESPACE__ . '\\sage_comment_callback';
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