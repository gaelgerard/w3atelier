<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * Nettoyage du header WordPress pour le SEO et la performance.
 */
add_action('init', function () {
    // Retire les liens vers les flux RSS des articles et commentaires
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    
    // Retire le lien vers l'API REST (souvent inutile dans le head)
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    
    // Retire le support des Emojis (on utilise les natifs du navigateur maintenant)
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // Retire les liens RSD (Remote Site Shutdown) et WLW Manifest (Windows Live Writer)
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    // Retire la version de WordPress (Sécurité + légèreté)
    remove_action('wp_head', 'wp_generator');

    // Retire les liens vers l'article suivant/précédent
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
});

/**
 * Charge les styles des blocs uniquement si nécessaire.
 */
add_filter('should_load_separate_core_block_assets', '__return_true');

// Load language files
add_action('after_setup_theme', function () {
    load_textdomain( 'sage', get_template_directory() . '/resources/lang/' . determine_locale() . '.mo' );
});

add_theme_support('custom-logo');

//Enregistrement des formulaires de contact depuis le site www.gaelgerard.com
if ( !function_exists('ggcom_react_form_save_and_notify')) {
	function ggcom_react_form_save_and_notify ( $dataForm ) {
		$from_name = $dataForm['from_name'] ?? '';
        $from_email = $dataForm['from_email'] ?? '';
        $from_phone = $dataForm['from_phone'] ?? '';
        $to_name = $dataForm['to_name'] ?? '';
        $source = $dataForm['source'] ?? '';
        $message_html = $dataForm['message_html'] ?? '';
        $subject = substr($message_html,0,50);
		global $wpdb;
		$table_db7_forms = $wpdb->prefix . "db7_forms"; // _ underscore déjà inclus dans wpdb->
     // Enregistrer le message entrant
        $message_data = array(
            'cfdb7_status' => 'unread',
            'channel' => 'contact-form-ggreact',
            'subject' => $subject,
            'from' => "$from_name <$from_email>",
            'from_name' => $from_name,
            'from_email' => $from_email,
            'phone' => $from_phone,
            'message' => $message_html,
            'RGPD' => 'Accepte les conditions et la politique de confidentialité',
            'source' => $source,
        );
        $data_to_be_inserted = array(
            'form_post_id' => 412,
            'form_value' => serialize($message_data),
            'form_date' => date_i18n('Y-m-d H:i:s', time()),
        );
        $message = $wpdb->insert($table_db7_forms , $data_to_be_inserted);
		$recipient = '';
        $recipient = 'gael.gerard@free.fr';
        $subject = 'Message sur le site : '.$subject;
		$body = '<html>';
		$body .= '<head>';
		$body .= '<title>Message depuis le site</title>';
		$body .= '</head>';
		$body .= '<body>';
        $body .= 'Message reçu de '.$from_name;
        $body .= '<br>Source : '.$source;
        $body .= '<br>Adresse email : '.$from_email;
        $body .= '<br>Téléphone : '.$from_phone;
        $body .= '<br>Message : '.$message_html;
        $body .= '<br>RGPD : '.$message_data['RGPD'];
		$body .= '</body>';
		$body .= '</html>';
		
        $headers = array(
            'From: "Contact ggcom" <no-reply@dev.gaelgerard.com>',
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: '.$from_email.'',
        );
        $attachments = '';
        
        if (wp_mail( $recipient, $subject, $body, $headers )) {
            $response = array(
                'status' => 'success',
                'message' => 'Contact and message saved successfully',
                'data' => array(
                    'message' => $message_data,
                ),
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to save contact or message',
            );
        }
		return $response;
	}
}
