<?php

namespace App\Models;

class CustomWalkerCategory extends \Walker_Category
{
    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
        extract($args);
        $cat_name = esc_attr($category->name);
        $cat_name = apply_filters('list_cats', $cat_name, $category);

        $link_classes = $this->getLinkClasses($category, $current_category);

        $link = $this->buildLink($category, $cat_name, $use_desc_for_title, $link_classes, $feed_image, $feed, $feed_type, $show_count);

        $output .= $this->buildOutput($link, $args, $category, $current_category);
    }

    private function getLinkClasses($category, $current_category)
    {
        $link_classes = array('font-mono', 'text-sm', 'uppercase', 'no-underline', 'mb-3');

        if ($category->term_id != $current_category) {
            $link_classes[] = 'hover:text-primary-600 dark:hover:text-primary-400 text-gray-600 dark:text-gray-300';
        } else {
            $link_classes[] = 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400';
        }

        return $link_classes;
    }

    private function buildLink($category, $cat_name, $use_desc_for_title, $link_classes, $feed_image, $feed, $feed_type, $show_count)
    {
        $link = '<a href="' . esc_url(get_term_link($category)) . '" ';

        if ($use_desc_for_title == 0 || empty($category->description)) {
            $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s'), $cat_name)) . '"';
        } else {
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        }

        $link .= ' class="' . implode(' ', $link_classes) . '">';
        $link .= $cat_name;

        if (!empty($feed_image) || !empty($feed)) {
            $link .= ' ';
            if (empty($feed_image)) {
                $link .= '(';
            }
            $link .= '<a href="' . esc_url(get_term_feed_link($category->term_id, $category->taxonomy, $feed_type)) . '"';
            if (empty($feed)) {
                $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s'), $cat_name) . '"';
            } else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
            }
            $link .= '>';
            if (empty($feed_image)) {
                $link .= $name;
            } else {
                $link .= "<img src='$feed_image'$alt$title" . ' />';
            }
            if (empty($feed_image)) {
                $link .= ')';
            }
        }

        if (!empty($show_count)) {
            $link .= ' (' . intval($category->count) . ')';
        }

        $link .= '</a>';

        return $link;
    }

    private function buildOutput($link, $args, $category, $current_category)
    {
        if ('list' == $args['style']) {
            $output = "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;

            if ($args['depth']) {
                $class .= ' sub-' . sanitize_title_with_dashes($category->name);
            }

            if (!empty($current_category)) {
                $_current_category = get_term($current_category, $category->taxonomy);
                if ($category->term_id == $current_category) {
                    $class .= ' current-cat';
                } elseif ($category->term_id == $_current_category->parent) {
                    $class .= ' current-cat-parent';
                }
            }

            $output .= ' class="' . $class . '"';
            $output .= ">$link\n";
        } else {
            $output = "\t$link<br />\n";
        }

        return $output;
    }
}