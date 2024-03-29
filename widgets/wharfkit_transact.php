<?php
namespace WordpressWharfkit\Widgets;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Widget_Wharftkit_Transact extends Widget_Base
{
    public function get_name()
    {
        return 'wharfkit-transact';
    }

    public function get_title()
    {
        return __('Wordpress Wharfkit Transact', 'wordpress-wharfkit');
    }

    public function get_icon()
    {
        return 'eicon-flash';
    }

    public function get_keywords()
    {
        return ['wax', 'blockchain', 'web3', 'transact', 'wharfkit'];
    }

    public function get_categories() {
        return [ 'wordpress-wharfkit' ];
    }


    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Transaction data', 'textdomain' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_label',
            [
                'label' => __('Button label', 'wordpress-wharfkit'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __("Transact", 'wordpress-wharfkit')
            ]
        );

        $this->add_control(
            'transaction_json_data',
            [
                'label' => __('Transaction Data', 'wordpress-wharfkit'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => __("[{
                    account: 'eosio.token',
                    name: 'transfer',
                    authorization: %actor_permission%,
                    data: {
                        from: %actor_name%,
                        to: 'we',
                        quantity: '0.00000001 WAX',
                        memo: 'wordpress wharfkit first action'
                    }
                 },{
                    account: 'eosio.token',
                    name: 'transfer',
                    authorization: %actor_permission%,
                    data: {
                        from: %actor_name%,
                        to: 'we',
                        quantity: '0.00000001 WAX',
                        memo: 'wordpress wharfkit second action'
                    }
                 }]", 'wordpress-wharfkit'),
                'description' => __('Enter transaction data object.', 'wordpress-wharfkit'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $appname = get_option('wordpresswharfkit_appname');
        $chain_id = get_option('wordpresswharfkit_chain_id');
        $chain_url = get_option('wordpresswharfkit_chain_url');

        $settings = $this->get_settings_for_display();

        $button_label = ( strlen($settings['button_label']) > 0) ? $settings['button_label'] : 'Transact' ;

        $transaction_data = $settings['transaction_json_data'];
        $transaction_data = str_replace('%actor_name%', 'wharfkit_data.actor_name', $transaction_data);
        $transaction_data = str_replace('%actor_permission%', '[wharfkit_data.session.permissionLevel]', $transaction_data);
    ?>
        <div class="wordpress-wharfkit-app wharfkit-transact" data-appname="<?= esc_attr( $appname ) ?>" data-chain-id="<?= esc_attr( $chain_id ) ?>" data-chain-url="<?= esc_attr( $chain_url ) ?>">
            <div class="wordpress-wharfkit-vif" data-var="isLoggedIn" data-value="true">
                <?php if(strlen($transaction_data)): ?>
                <button onclick="wharfkit_transact(<?= $transaction_data ?>)"><?= esc_attr( $button_label ) ?></button>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }

    protected function _content_template() {
        $appname = get_option('wordpresswharfkit_appname');
        $chain_id = get_option('wordpresswharfkit_chain_id');
        $chain_url = get_option('wordpresswharfkit_chain_url');
        ?>
        <div class="wharfkit-transact-backoffice">
            <div>Wordpress Wharfkit Transact</div>
            <ul>
                <li>Button label: {{ settings.button_label }}</li>
                <li>Transaction data: {{ settings.transaction_json_data }}</li>
            </ul>
            <ul>
                <li>appName: <?= esc_attr($appname) ?></li>
                <li>chain_id: <?= esc_attr($chain_id) ?></li>
                <li>chain_url: <?= esc_attr($chain_url) ?></li>
            </ul>
        </div>
        <?php
    }
}
