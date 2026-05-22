<?php
defined( 'ABSPATH' ) || exit;

class DiscloAI_Settings {

    public static function init(): void {
        add_action( 'admin_menu', [ __CLASS__, 'add_settings_page' ] );
        add_action( 'admin_init', [ __CLASS__, 'register_settings' ] );
    }

    public static function add_settings_page(): void {
        add_options_page(
            esc_html__( 'DiscloAI Settings', 'discloai-disclosure' ),
            esc_html__( 'DiscloAI', 'discloai-disclosure' ),
            'manage_options',
            'discloai-disclosure',
            [ __CLASS__, 'render_settings_page' ]
        );
    }

    public static function register_settings(): void {
        register_setting(
            'discloai_settings_group',
            DISCLOAI_OPTION_KEY,
            [
                'type'              => 'array',
                'sanitize_callback' => [ __CLASS__, 'sanitize_settings' ],
                'default'           => [],
            ]
        );

        add_settings_section(
            'discloai_main_section',
            esc_html__( 'SDK Configuration', 'discloai-disclosure' ),
            '__return_false',
            'discloai-disclosure'
        );

        add_settings_field(
            'site_id',
            esc_html__( 'Site ID', 'discloai-disclosure' ),
            [ __CLASS__, 'render_site_id_field' ],
            'discloai-disclosure',
            'discloai_main_section'
        );

        add_settings_field(
            'enabled',
            esc_html__( 'Enable DiscloAI', 'discloai-disclosure' ),
            [ __CLASS__, 'render_enabled_field' ],
            'discloai-disclosure',
            'discloai_main_section'
        );
    }

    /**
     * Sanitize all settings inputs.
     * sanitize_text_field strips HTML tags, extra whitespace, and invalid UTF-8.
     *
     * @param mixed $input Raw input from form POST.
     * @return array Sanitized settings array.
     */
    public static function sanitize_settings( mixed $input ): array {
        if ( ! is_array( $input ) ) {
            return [];
        }

        $sanitized = [];

        // site_id: alphanumeric + hyphens only — strip anything else
        $raw_site_id = sanitize_text_field( $input['site_id'] ?? '' );
        $sanitized['site_id'] = preg_replace( '/[^a-zA-Z0-9\-_]/', '', $raw_site_id );

        // enabled: checkbox — cast to bool
        $sanitized['enabled'] = ! empty( $input['enabled'] );

        return $sanitized;
    }

    public static function render_settings_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions.', 'discloai-disclosure' ) );
        }
        $settings = get_option( DISCLOAI_OPTION_KEY, [] );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <p><?php esc_html_e( 'Configure your DiscloAI site ID to start displaying EU AI Act Article 50 disclosures.', 'discloai-disclosure' ); ?></p>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'discloai_settings_group' );
                do_settings_sections( 'discloai-disclosure' );
                submit_button( esc_html__( 'Save Settings', 'discloai-disclosure' ) );
                ?>
            </form>
            <?php if ( ! empty( $settings['site_id'] ) && ! empty( $settings['enabled'] ) ) : ?>
            <hr />
            <h2><?php esc_html_e( 'Installation Verification', 'discloai-disclosure' ); ?></h2>
            <p><?php esc_html_e( 'The following script tag will be injected into your site\'s', 'discloai-disclosure' ); ?> <code>&lt;head&gt;</code>:</p>
            <pre style="background:#f0f0f1;padding:12px;border-radius:4px;overflow-x:auto;">&lt;script
  src="<?php echo esc_url( DISCLOAI_CDN_URL ); ?>"
  data-site-id="<?php echo esc_attr( $settings['site_id'] ); ?>"
  defer&gt;&lt;/script&gt;</pre>
            <?php endif; ?>
        </div>
        <?php
    }

    public static function render_site_id_field(): void {
        $settings = get_option( DISCLOAI_OPTION_KEY, [] );
        $site_id  = esc_attr( $settings['site_id'] ?? '' );
        ?>
        <input
            type="text"
            id="discloai_site_id"
            name="<?php echo esc_attr( DISCLOAI_OPTION_KEY ); ?>[site_id]"
            value="<?php echo $site_id; ?>"
            class="regular-text"
            placeholder="e.g. abc123xyz"
            pattern="[a-zA-Z0-9\-_]+"
            autocomplete="off"
        />
        <p class="description">
            <?php
            printf(
                /* translators: %s: dashboard URL */
                esc_html__( 'Find your Site ID in the %s.', 'discloai-disclosure' ),
                '<a href="https://app.discloai.com/dashboard" target="_blank" rel="noopener">'
                    . esc_html__( 'DiscloAI dashboard', 'discloai-disclosure' )
                    . '</a>'
            );
            ?>
        </p>
        <?php
    }

    public static function render_enabled_field(): void {
        $settings = get_option( DISCLOAI_OPTION_KEY, [] );
        $enabled  = ! empty( $settings['enabled'] );
        ?>
        <label for="discloai_enabled">
            <input
                type="checkbox"
                id="discloai_enabled"
                name="<?php echo esc_attr( DISCLOAI_OPTION_KEY ); ?>[enabled]"
                value="1"
                <?php checked( $enabled ); ?>
            />
            <?php esc_html_e( 'Enable DiscloAI on this site', 'discloai-disclosure' ); ?>
        </label>
        <?php
    }
}
