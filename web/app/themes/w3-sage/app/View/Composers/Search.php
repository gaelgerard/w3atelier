<?php 
namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Search extends Composer
{
    /**
     * Liste des vues qui recevront ces données.
     */
    protected static $views = [
        'search',
    ];

    /**
     * Données à passer à la vue.
     */
    public function with()
    {
        return [
            'result_count' => $GLOBALS['wp_query']->found_posts,
        ];
    }
}