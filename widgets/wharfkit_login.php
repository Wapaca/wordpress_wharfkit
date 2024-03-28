<?php
namespace Cookiz_Elementor\Widgets;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class Widget_Wharftkit_Login extends Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'wharfkit-login';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('WAX - Wharfkit Login', 'elementor-wharfkit-login');
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-image-box';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['wax', 'blockchain', 'web3', 'login'];
    }

    public function get_categories() {
		return [ 'wax-wharfkit' ];
	}

    protected function register_controls() {

        // Content Tab Start

        $this->start_controls_section(
            'chain_settings_section',
            [
                'label' => esc_html__( 'Chain settings', 'wax-wharfkit' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'appname',
            [
                'label' => esc_html__( 'App Name', 'wax-wharfkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'my wharfkit app', 'wax-wharfkit' ),
            ]
        );
        $this->add_control(
            'chain_id',
            [
                'label' => esc_html__( 'Chain ID', 'wax-wharfkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '1064487b3cd1a897ce03ae5b6a865651747e2e152090f99c1d19d44e01aea5a4', 'wax-wharfkit' ),
            ]
        );
        $this->add_control(
            'chain_url',
            [
                'label' => esc_html__( 'Chain URL', 'wax-wharfkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'https://wax.greymass.com', 'wax-wharfkit' ),
            ]
        );

        $this->end_controls_section();

        // Content Tab End
    }

    /**
     * Render image box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings();

        $appname = $settings['appname'];
        $chain_id = $settings['chain_id'];
        $chain_url = $settings['chain_url'];
    ?>
        <div class="cookiz-wharfkit-app wharfkit-login" data-appname="<?= esc_attr( $appname ) ?>" data-chain-id="<?= esc_attr( $chain_id ) ?>" data-chain-url="<?= esc_attr( $chain_url ) ?>">
            <h2>TEST IT WORKS</h2>
            <div class="cookiz-wharfkit-vif" data-var="isLoggedIn" data-value="true">
                <div class="cookiz-wharfkit-variable" data-var="actor_name"></div>
                <button onclick="wharfkit_transact([{
                        account: 'eosio.token',
                        name: 'transfer',
                        authorization: [wharfkit_data.session.permissionLevel],
                        data: {
                            from: wharfkit_data.actor_name,
                            to: 'waxpaca.fx',
                            quantity: '0.00000001 WAX',
                            memo: 'made from wordpress'
                        }
                    }])">TEST transact</button>
                <button onclick="wharfkit_logout()">Logout</button>
            </div>
            <div class="cookiz-wharfkit-vif" data-var="isLoggedIn" data-value="false">
                <button onclick="wharfkit_login()">Login button</button>
            </div>
        </div>
    <?php
    }

    /**
	 * Render image box widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="wharfkit-login-backoffice">
            <div>Wax Wharfkit Login</div>
            <ul>
                <li>appName: {{{ settings.appname }}}</li>
                <li>chain_id: {{{ settings.chain_id }}}</li>
                <li>chain_url: {{{ settings.chain_url }}}</li>
            </ul>
        </div>
		<?php
	}
}
