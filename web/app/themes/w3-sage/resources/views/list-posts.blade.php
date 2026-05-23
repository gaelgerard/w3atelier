<?php
/**
 * Template Name: List all posts on page
 */

// On récupère le contenu de la page avant de modifier la boucle
$page_content = '';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $page_content = get_the_content();
    }
}

// On prépare la pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// ON ÉCRASE LA REQUÊTE GLOBALE
// Cela permet à have_posts() dans index.blade.php de voir les articles
query_posts([
    'post_type' => 'post',
    'paged' => $paged,
    'posts_per_page' => get_option('posts_per_page')
]);

echo view('index', ['page_content' => $page_content]);