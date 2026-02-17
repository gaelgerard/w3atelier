<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;
use App\Models\CustomWalkerCategory; // N'oubliez pas l'import ici !

class CategoryList extends Component
{
    /** @var array */
    public $args;

    public function __construct($showCount = true, $exclude = '')
    {
        $uncategorized = get_term_by('slug', $exclude, 'category');
        $exclude_id = $uncategorized ? $uncategorized->term_id : '';
        // On prépare la logique ici
        $walker = new CustomWalkerCategory();
        
        $this->args = [
            'walker'            => $walker,
            'style'             => 'list',
            'show_count'        => $showCount, // Exemple de paramètre dynamique
            'use_desc_for_title'=> false,
            'title_li'          => '',
            'exclude'           => $exclude_id,
        ];
    }

    public function render()
    {
        return $this->view('components.category-list');
    }
}