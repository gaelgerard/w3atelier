<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    protected static $views = [
        '*',
    ];

    public function with(): array
    {
        // Récupérer l'ID de l'auteur du post actuel
        $author_id = get_post_field('post_author', get_the_ID());
        
        $url = get_the_author_meta('user_url', $author_id);

        $avatar = get_avatar($author_id, $size = '60', $default = '', $alt = '', $args = array( 'class' => 'h-10 w-10 rounded-full' ) );

        return [
            'site_name'     => $this->siteName(),
            'author_url'    => $url ?: '',
            'author_domain' => $this->getCleanDomain($url),
            'author_avatar' => $avatar,
        ];
    }

    /**
     * Nettoyage du nom de domaine
     */
    private function getCleanDomain($url)
    {
        if (!$url) return '';

        // Ajout du protocole si absent pour parse_url
        if (!str_starts_with($url, 'http')) {
            $url = 'https://' . $url;
        }

        $host = parse_url($url, PHP_URL_HOST);
        return str_replace('www.', '', $host ?? '');
    }

    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }
}