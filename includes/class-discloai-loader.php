<?php
defined( 'ABSPATH' ) || exit;

class DiscloAI_Loader {

    public static function init(): void {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_script' ] );
        add_filter( 'script_loader_tag', [ __CLASS__, 'add_defer_and_site_id' ], 10, 3 );
    }

    /**
     * Enqueue the DiscloAI CDN script if enabled and site_id is set.
     */
    public static function enqueue_script(): void {
        $settings = get_option( DISCLOAI_OPTION_KEY, [] );
        $site_id  = sanitize_text_field( $settings['site_id'] ?? '' );
        $enabled  = ! empty( $settings['enabled'] );

        if ( ! $enabled || empty( $site_id ) ) {
            return;
        }

        wp_enqueue_script(
            'discloai-disclosure',
            DISCLOAI_CDN_URL,
            [],           // no dependencies
            DISCLOAI_VERSION,
            false         // load in <head> (not footer) — SDK must run before chat widgets
        );
    }

    /**
     * Modify the rendered <script> tag to add data-site-id and defer.
     * Uses script_loader_tag filter — the only safe way to add custom attributes
     * to enqueued scripts in WordPress.
     *
     * @param string $tag    The rendered <script> HTML tag.
     * @param string $handle The script handle.
     * @param string $src    The script src URL.
     * @return string Modified script tag or original.
     */
    public static function add_defer_and_site_id( string $tag, string $handle, string $src ): string {
        if ( 'discloai-disclosure' !== $handle ) {
            return $tag;
        }

        $settings = get_option( DISCLOAI_OPTION_KEY, [] );
        $site_id  = sanitize_text_field( $settings['site_id'] ?? '' );
        // Re-validate: alphanumeric + hyphens only
        $site_id  = preg_replace( '/[^a-zA-Z0-9\-_]/', '', $site_id );

        if ( empty( $site_id ) ) {
            return $tag;
        }

        // Replace the existing <script ...> opening tag with our custom attributes.
        // esc_attr() prevents XSS via the site_id attribute value.
        $new_tag = str_replace(
            '<script ',
            '<script data-site-id="' . esc_attr( $site_id ) . '" defer ',
            $tag
        );

        return $new_tag;
    }
}
