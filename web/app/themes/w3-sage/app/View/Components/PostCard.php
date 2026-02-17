<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class PostCard extends Component
{
    public $post;

    public function __construct($post = null)
    {
        // Si aucun post n'est passé, on prend le post courant de la Loop
        $this->post = $post ?? get_post();
    }

    public function render()
    {
        return $this->view('components.post-card');
    }
}