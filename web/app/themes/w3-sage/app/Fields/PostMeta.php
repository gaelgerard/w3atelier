<?php
namespace App\Fields;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'featured-post',
        __('Featured post', 'sage'),
        function ($post) {
            // 1. Création du jeton de sécurité (Nonce)
            wp_nonce_field('save_featured_meta', 'featured_meta_nonce');
            
            $featured = get_post_meta($post->ID, '_featured_post', true);
            echo \Roots\view('admin.fields.featured-checkbox', ['checked' => $featured])->render();
        },
        'post',
        'side'
    );
});

add_action('save_post', function ($post_id) {
    // A. Vérification de sécurité (Nonce)
    if (!isset($_POST['featured_meta_nonce']) || !wp_verify_nonce($_POST['featured_meta_nonce'], 'save_featured_meta')) {
        return;
    }

    // B. Vérification des permissions de l'utilisateur
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // C. Éviter l'écrasement lors de la sauvegarde automatique (Autosave)
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // D. Traitement de la donnée
    if (isset($_POST['_featured_post'])) {
        // On sanitize (nettoie) même pour une checkbox
        update_post_meta($post_id, '_featured_post', '1');
    } else {
        delete_post_meta($post_id, '_featured_post');
    }
});