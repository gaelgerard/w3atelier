<?php
namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class FrontPage extends Composer
{
    protected static $views = ['front-page']; // S'applique à front-page.blade.php

    public function with()
    {
        return [
            'featuredpost' => $this->getFeaturedPost(),
        ];
    }

    public function getFeaturedPost()
    {
        $args = [
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'meta_query'     => [[
                'key'   => '_featured_post',
                'value' => '1',
            ]]
        ];

        $query = new WP_Query($args);
        return $query->posts[0] ?? null;
    }
}