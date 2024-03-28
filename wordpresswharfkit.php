<?php
/**
 * Plugin Name: Wordpress Wharfkit
 * Description: Elementor addon implementing Wharfkit for Antelope blockchains
 * Plugin URI:  https://twitter.com/Wapaca
 * Version:     1.0.0
 * Author:      Waxpaca
 * Author URI:  https://twitter.com/Wapaca
 * Text Domain: wordpresswharfkit
 */
namespace WordpressWharfkit;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class WordpressWharfkit_extension
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var WordpressWharfkit_extension The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return WordpressWharfkit_extension An instance of the class.
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct()
    {
        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function i18n()
    {

        load_plugin_textdomain('elementor-test-extension');

    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        //Register Widget Category
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);


        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets'], 20);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension'),
            '<strong>' . esc_html__('Elementor Test Extension', 'elementor-test-extension') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-test-extension') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Create Category
     *
     * @param [type] $elements_manager
     * @return void
     */
    function add_elementor_widget_categories($elements_manager)
    {

        $elements_manager->add_category(
            'wordpress-wharfkit',
            [
                'title' => __('Wordpress Wharfkit', 'wordpress-wharfkit'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    public static function register_settings() {
        add_settings_section( 'wordpresswharfkit_settings', 'Wordpress Wharfkit', array('WordpressWharfkit\WordpressWharfkit_extension', 'wordpresswharfkit_settings_section_callback'), 'general' );
        register_setting( 'general', 'wordpresswharfkit_appname' );
        register_setting( 'general', 'wordpresswharfkit_chain_id' );
        register_setting( 'general', 'wordpresswharfkit_chain_url' );
    }

    // Activation hook for your plugin
    public static function wordpresswharfkit_activation() {
        // Set default values for options if they don't exist
        if ( ! get_option( 'wordpresswharfkit_appname' ) ) {
            add_option( 'wordpresswharfkit_appname', 'Go into general settings to change App Name' );
        }

        if ( ! get_option( 'wordpresswharfkit_chain_id' ) ) {
            add_option( 'wordpresswharfkit_chain_id', '1064487b3cd1a897ce03ae5b6a865651747e2e152090f99c1d19d44e01aea5a4' );
        }

        if ( ! get_option( 'wordpresswharfkit_chain_url' ) ) {
            add_option( 'wordpresswharfkit_chain_url', 'https://wax.eosphere.io' );
        }
    }

    public static function settings_fields() {
        add_settings_field( 'wordpresswharfkit_appname', 'App Name', array('WordpressWharfkit\WordpressWharfkit_extension', 'appname_callback'), 'general', 'wordpresswharfkit_settings' );
        add_settings_field( 'wordpresswharfkit_chain_id', 'Chain id', array('WordpressWharfkit\WordpressWharfkit_extension', 'chain_id_callback'), 'general', 'wordpresswharfkit_settings' );
        add_settings_field( 'wordpresswharfkit_chain_url', 'Chain URL', array('WordpressWharfkit\WordpressWharfkit_extension', 'chain_url_callback'), 'general', 'wordpresswharfkit_settings' );
    }

    public static function wordpresswharfkit_settings_section_callback() {
        return;
    }

    // Callback functions for settings fields
    public static function appname_callback() {
        echo '<input type="text" name="wordpresswharfkit_appname" class="regular-text code" value="' . esc_attr( get_option('wordpresswharfkit_appname') ) . '" />';
    }

    public static function chain_id_callback() {
        echo '<input type="text" name="wordpresswharfkit_chain_id" class="regular-text code" value="' . esc_attr( get_option('wordpresswharfkit_chain_id') ) . '" />';
    }

    public static function chain_url_callback() {
        echo '<input type="text" name="wordpresswharfkit_chain_url" class="regular-text code" value="' . esc_attr( get_option('wordpresswharfkit_chain_url') ) . '" />';
    }

    public static function register_widget_scripts() {
        wp_register_script( 'wharfkit', plugins_url( 'lib/wharfkit.js', __FILE__ ));
        wp_register_script( 'main', plugins_url( 'main.js', __FILE__ ), ['wharfkit']);
        wp_enqueue_script( 'wharfkit' );
        wp_enqueue_script( 'main' );
    }

    public static function set_scripts_type_attribute( $attributes ) {
      // Only do this for a specific script.
      if ( isset( $attributes['id'] ) && in_array($attributes['id'], ['wharfkit-js', 'main-js']) ) {
        $attributes['type'] = 'module';
      }

      return $attributes;
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_widgets($wm)
    {

        // Include Widget files
        require_once __DIR__ . '/widgets/wharfkit_login.php';

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Widget_Wharftkit_Login());

    }
}

register_activation_hook( __FILE__, array('WordpressWharfkit\WordpressWharfkit_extension', 'wordpresswharfkit_activation') );
add_action( 'admin_init', array('WordpressWharfkit\WordpressWharfkit_extension', 'register_settings') );
add_action( 'admin_init', array('WordpressWharfkit\WordpressWharfkit_extension', 'settings_fields') );
add_action( 'wp_enqueue_scripts', array( 'WordpressWharfkit\WordpressWharfkit_extension', 'register_widget_scripts') );
add_filter( 'wp_script_attributes', array('WordpressWharfkit\WordpressWharfkit_extension', 'set_scripts_type_attribute'), 10, 1 );
WordpressWharfkit_extension::instance();