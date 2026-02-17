<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
        'components.post-*'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'title' => $this->title(),
            'pagination' => $this->pagination(),
            'is_significantly_modified' => $this->isSignificantlyModified(),
        ];
    }

    /**
     * Check if post was modified more than 30 days after publication.
     */
    public function isSignificantlyModified(): bool
    {
        // On récupère l'ID du post actuel géré par le Composer
        $post_id = get_the_ID(); 
        $published = get_the_time('U', $post_id);
        $modified = get_the_modified_time('U', $post_id);
        $one_month = 30 * 24 * 60 * 60;

        return $modified > ($published + $one_month);
    }

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
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }

        return is_404() ? __('Not Found', 'sage') : get_the_title();
    }

    public function pagination(): string
    {
        $excluded_categories = '1'; 

        $prev = get_previous_post_link(
            '<div class="nav-previous">%link</div>',
            __('&laquo;&nbsp;Previous post: %title', 'sage'),
            false,
            $excluded_categories,
            'category'
        );

        $next = get_next_post_link(
            '<div class="nav-next">%link</div>',
            __('Next post: %title&nbsp;&raquo;', 'sage'),
            false,
            $excluded_categories,
            'category'
        );

        return '
            <h2 class="screen-reader-text">Post navigation</h2>
            <nav class="post-navigation">
                <div class="nav-links">' . $prev . $next . '</div>
            </nav>';
    }
}