<?php
namespace WordpressWharfkit\Widgets;
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
        return __('Wordpress Wharfkit Login', 'wordpress-wharfkit');
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
		return [ 'wordpress-wharfkit' ];
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
        $appname = get_option('wordpresswharfkit_appname');
        $chain_id = get_option('wordpresswharfkit_chain_id');
        $chain_url = get_option('wordpresswharfkit_chain_url');
    ?>
        <div class="wordpress-wharfkit-app wharfkit-login" data-appname="<?= esc_attr( $appname ) ?>" data-chain-id="<?= esc_attr( $chain_id ) ?>" data-chain-url="<?= esc_attr( $chain_url ) ?>">
            <div class="wordpress-wharfkit-vif" data-var="isLoggedIn" data-value="true">
                <div class="wordpress-wharfkit-variable" data-var="actor_name"></div>
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
            <div class="wordpress-wharfkit-vif" data-var="isLoggedIn" data-value="false">
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
        $appname = get_option('wordpresswharfkit_appname');
        $chain_id = get_option('wordpresswharfkit_chain_id');
        $chain_url = get_option('wordpresswharfkit_chain_url');
		?>
		<div class="wharfkit-login-backoffice">
            <div>Wordpress Wharfkit Login</div>
            <ul>
                <li>appName: <?= esc_attr($appname) ?></li>
                <li>chain_id: <?= esc_attr($chain_id) ?></li>
                <li>chain_url: <?= esc_attr($chain_url) ?></li>
            </ul>
        </div>
		<?php
	}
}
