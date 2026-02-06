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

    public function renderTagList()
    {
        $tags = $this->tagModel->getTags();
        $current_tag_id = $this->tagModel->getCurrentTagId();

        return view('partials.tags-list', [
            'tags' => $tags,
            'current_tag_id' => $current_tag_id,
            'classes' => function ($tag_id, $current_tag_id) {
                $classes = [
                    'font-mono',
                    'text-sm',
                    'uppercase',
                    'no-underline'
                ];

                if ($tag_id == $current_tag_id) {
                    $classes[] = 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400';
                } else {
                    $classes[] = 'hover:text-primary-600 dark:hover:text-primary-400 text-gray-600 dark:text-gray-300';
                }

                return $classes;
            }
        ]);
    }
}