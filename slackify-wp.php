<?php
/*
 * Plugin Name:       Slickify WP
 * Plugin URI:        https://github.com/kamalahmed/slickify-wp
 * Description:       Sends notifications to the slack channel when a new question is posted, new order is placed.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Kamal Ahmed
 * Author URI:        https://github.com/kamalahmed
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       slickify-wp
 * Domain Path:       /languages
 */


class Slickify_WP
{
    protected $slack_webhook_url = '';
    public function __construct()
    {
        add_action('woocommerce_new_order', [$this, 'send_slack_order_notification'], 10, 1);
        add_action('save_post_dwqa-question', [$this, 'send_slack_forum_notification'], 10, 3);
        add_action('save_post_dwqa-answer', [$this, 'send_slack_forum_notification'], 10, 3);
        $this->slack_webhook_url = defined('SLACK_WEBHOOK_URL') ? SLACK_WEBHOOK_URL : 'https://hooks.slack.com/services/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';

    }



    function send_slack_order_notification($order_id)
    {
        $order = wc_get_order($order_id);
        $order_data = $order->get_data();

        $message = "A new order has been placed on https://techydevs.com!\n";
        $message .= "Order ID: " . $order_data['id'] . "\n";
        $message .= "Order Total: " . $order_data['total'] . "\n";
        $message .= "Customer: " . $order_data['billing']['first_name'] . " " . $order_data['billing']['last_name'] . "\n";

        $payload = array(
            'text' => $message
        );

        $args = array(
            'body'        => json_encode($payload),
            'headers'     => array('Content-Type' => 'application/json'),
            'httpversion' => '1.1',
            'method'      => 'POST'
        );

        $response = wp_remote_post($this->slack_webhook_url, $args);
    }


    function send_slack_forum_notification($post_id, $post, $update)
    {
        if ($update) {
            return;
        }

        if ( !in_array($post->post_type, array('dwqa-answer', 'dwqa-question'))) {
            return;
        }

        $post_title = get_the_title($post_id);
        $post_url = get_permalink($post_id);
        $message = '';
        switch ($post->post_type) {

            case 'dwqa-question':
                $message = "A new question has been posted on https://techydevs.com!\n";
                $message.= "Question Title: ". $post_title. "\n";
                $message.= "Question URL: ". $post_url. "\n";
                break;

            case 'dwqa-answer':
                $message = "A new answer has been posted on https://techydevs.com!\n";
                $message.= "Answer Title: *". $post_title. "*\n";
                $message.= "Answer URL: ". $post_url. "\n";
                break;
        }


        $payload = json_encode([
            'text' => $message,
        ]);

        wp_remote_post($this->slack_webhook_url, [
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'body' => $payload,
            'method' => 'POST',
            'data_format' => 'body',
        ]);
    }
}

new Slickify_WP();
