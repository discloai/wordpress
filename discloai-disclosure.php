<?php
/**
 * Plugin Name:       DiscloAI — EU AI Act Article 50 Disclosures
 * Plugin URI:        https://discloai.com
 * Description:       Automatically display EU AI Act Article 50 disclosures on your website. Chatbot disclosure, AI content labels, deepfake labels, and biometric notices — all in one script tag.
 * Version:           0.1.0
 * Author:            DiscloAI
 * Author URI:        https://discloai.com
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       discloai-disclosure
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

defined( 'ABSPATH' ) || exit;

define( 'DISCLOAI_VERSION', '0.1.0' );
define( 'DISCLOAI_CDN_URL', 'https://cdn.discloai.com/discloai.min.js' );
define( 'DISCLOAI_OPTION_KEY', 'discloai_settings' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-discloai-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-discloai-loader.php';

DiscloAI_Settings::init();
DiscloAI_Loader::init();
