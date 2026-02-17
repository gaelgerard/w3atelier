<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class PostCard extends Component
{
    public $post;
    public $showBadge;
    public $category; // On déclare la variable ici

    public function __construct($post = null, $showBadge = true)
    {
        $this->post = $post ? get_post($post) : get_post();
        $this->showBadge = $showBadge;

        // On récupère la première catégorie du post
        $categories = get_the_category($this->post->ID);
        $this->category = !empty($categories) ? $categories[0] : null;
    }

    public function render()
    {
        return $this->view('components.post-card');
    }
}