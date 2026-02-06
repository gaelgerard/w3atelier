<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    /**
     * Retrieve the pagination links.
     */
    public function pagination(): string
    {
        // ID de la catégorie à exclure (à adapter si différent de 1)
        $excluded_categories = '1'; 

        $prev = get_previous_post_link(
            '<div class="nav-previous">%link</div>',
            __('&laquo;&nbsp;Previous post: %title', 'sage'),
            false, // in_same_term : false pour naviguer partout
            $excluded_categories, // Les IDs à exclure (string séparée par des virgules)
            'category'
        );

        $next = get_next_post_link(
            '<div class="nav-next">%link</div>',
            __('Next post: %title&nbsp;&raquo;', 'sage'),
            false,
            $excluded_categories,
            'category'
        );

        return '<h2 class="screen-reader-text">Post navigation</h2>
                <nav class="post-navigation">
                <div class="nav-links">
                ' . $prev . $next . '
                </div>
                </nav>
                ';
    }
}