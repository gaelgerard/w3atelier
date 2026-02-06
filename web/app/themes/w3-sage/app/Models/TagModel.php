<?php

namespace App\Models;

class TagModel
{
    public function getTags()
    {
        $tags = get_tags();
        if (empty($tags)) {
            return [];
        }

        // Sort tags by count in descending order
        usort($tags, function ($a, $b) {
            return $b->count - $a->count;
        });

        return $tags;
    }

    public function getCurrentTagId()
    {
        return is_tag() ? get_queried_object_id() : 0;
    }
}