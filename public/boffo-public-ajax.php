<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Public_Ajax {

    public function post() {

        $items = self::sanitizeItems($_POST['items']);
        $url = esc_url_raw($_POST['url']);
        $id = sanitize_text_field($_POST['id']);

        $flow = Boffo_Flow::getFlow($id);

        // Create subscription post
        $post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_title'		=>	$flow['title'] . ' - ' . date('m/d/Y g:i A'),
				'post_status'		=>	'publish',
				'post_type'		    =>	'boffo_message'
			)
        );
        
        add_post_meta($post_id, 'items', $items);
        add_post_meta($post_id, 'url', $url);
        add_post_meta($post_id, 'flow_id', $id);
        add_post_meta($post_id, 'flow_title', $flow['title']);
        
        $this->deliverConfirmation($items, $flow, $url);

        wp_send_json('Successfully saved boffo', 200);
    }

    protected function deliverConfirmation($items, $flow, $url) {
        switch($flow['delivery_method']) {
            case "email":
                Boffo_Email::deliver($items, $flow, $url);
                break;
            default:
                Boffo_Email::deliver($items, $flow, $url);
                break;
        }
    }

    protected function sanitizeItems($items) {
        $sanitizedItems = array();

        for($i = 0; $i < count($items); $i++) {
            $sanitizedItems[$i] = array();

            foreach ($items[$i] as $key => $value) {
                $sanitizedItems[$i][$key] = sanitize_text_field($value);
            }
        }
        
        return $sanitizedItems;
    }

}
