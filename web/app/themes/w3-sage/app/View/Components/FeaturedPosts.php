<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;
use WP_Query;

class FeaturedPosts extends Component
{
    public $query;
    public $type;
    public $title;
    public $length;

    public function __construct($type = 'lectures', $count = 3, $title = null, $length = 500)
    {
        $this->type = $type;
        $this->title = $title;
        $this->length = $length; // Initialisez la variable (150 par défaut)
        $this->query = new WP_Query([
            'post_type'      => ['post', 'page'],
            'posts_per_page' => $count,
            'meta_query'     => [[
                'key'   => '_featured_post',
                'value' => '1',
            ]]
        ]);
    }

    public function render()
    {
        return $this->view('components.featured-posts');
    }
}