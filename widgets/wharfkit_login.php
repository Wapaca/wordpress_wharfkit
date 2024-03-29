<?php
namespace WordpressWharfkit\Widgets;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Widget_Wharftkit_Login extends Widget_Base
{
    public function get_name()
    {
        return 'wharfkit-login';
    }

    public function get_title()
    {
        return __('Wordpress Wharfkit Login', 'wordpress-wharfkit');
    }

    public function get_icon()
    {
        return 'eicon-image-box';
    }

    public function get_keywords()
    {
        return ['wax', 'blockchain', 'web3', 'login', 'wharfkit'];
    }

    public function get_categories() {
		return [ 'wordpress-wharfkit' ];
	}


    protected function render()
    {
        $appname = get_option('wordpresswharfkit_appname');
        $chain_id = get_option('wordpresswharfkit_chain_id');
        $chain_url = get_option('wordpresswharfkit_chain_url');
    ?>
        <div class="wordpress-wharfkit-app wharfkit-login" data-appname="<?= esc_attr( $appname ) ?>" data-chain-id="<?= esc_attr( $chain_id ) ?>" data-chain-url="<?= esc_attr( $chain_url ) ?>">
            <div class="wordpress-wharfkit-vif" data-var="isLoggedIn" data-value="true">
                <div class="wordpress-wharfkit-variable" data-var="actor_name"></div>
                <button onclick="wharfkit_logout()">Logout</button>
            </div>
            <div class="wordpress-wharfkit-vif" data-var="isLoggedIn" data-value="false">
                <button onclick="wharfkit_login()">Login button</button>
            </div>
        </div>
    <?php
    }

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
