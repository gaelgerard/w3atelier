<?php

namespace App\Controllers;

use App\Models\TagModel;

class TagController extends Controller
{
    protected $tagModel;

    public function __construct(TagModel $tagModel)
    {
        $this->tagModel = $tagModel;
    }

    public function renderTagList($format = 'list') // 'list' ou 'cloud'
    {
        $tags = $this->tagModel->getTags();
        $current_tag_id = $this->tagModel->getCurrentTagId();
        $isCloud = $format === 'cloud';

        return view('partials.tags-list', [
            'tags' => $tags,
            'current_tag_id' => $current_tag_id,
            'isCloud' => $isCloud, // On passe l'info à la vue
            'classes' => function ($tag_id, $current_tag_id) use ($isCloud) {
                // Classes de base communes
                $classes = ['text-sm', 'no-underline', 'transition-all'];

                if ($isCloud) {
                    // Look "Nuage" : Boutons arrondis
                    $classes[] = '';
                } else {
                    // Look "Liste" : Style classique
                    $classes[] = 'font-mono uppercase hover:underline block py-1';
                }

                // Gestion de la couleur Active/Inactive
                if ($tag_id == $current_tag_id) {
                    $classes[] = 'text-primary-500 font-bold';
                } else {
                    $classes[] = 'text-gray-600 dark:text-gray-300 hover:text-primary-600';
                }

                return $classes;
            }
        ]);
    }
    public static function no_index_lowtags()
    {
        if (is_tag()) {
            $term = get_queried_object();
            if ($term && $term->count < 3) {
                echo '<meta name="robots" content="noindex">' . "\n";
            }
        }
    }

}