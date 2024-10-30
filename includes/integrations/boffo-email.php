<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes/integrations
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Email {

	public static function deliver($items, $flow, $url) {
        $toEmail = get_bloginfo('admin_email');

        $to = $toEmail;
        $subject = 'Boffo flow submission - ' . $flow['title'];
        $body = self::buildEmailBody($items, $flow);
        $headers = array('Content-Type: text/html; charset=UTF-8');

        try {
			wp_mail($to, $subject, $body, $headers);
        }
        catch(Exception $e) {
			error_log($e);
        }
    }

    protected static function buildEmailBody($items, $flow) {
        $htmlBody = '<strong>Submission details</strong><br><br><em>Flow steps responses:</em><br><br>';

        $htmlBody .= '<ol>';

        foreach($items as $item) {
            $htmlBody .= '<li>';
            $htmlBody .= $item['text'] . ': <strong>' . $item['value'] . '</strong>';
            $htmlBody .= '</li>';
        }

        $htmlBody .= '</ol>';

        return $htmlBody;
    }

}
