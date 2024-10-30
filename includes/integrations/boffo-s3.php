<?php
use Aws\S3\S3Client;

/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes/integrations
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_S3 {

	public static function deliver($items, $flow, $url) {

        try {
			// TODO: Integrate wp_options for s3 settings
            $s3client = new S3Client([
                'version'     => 'latest',
                'region'      => 'us-east-1',
                'credentials' => [
                    'key'     => 'AKIAJYQVU3RWFRKZLHYA',
                    'secret'  => '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'
                ],
            ]);

            $body = "Flow '{$flow['title']}' from {$url}\n\n";

            for($i = 0; $i < count($flow['items']); $i++) {
                $body .= "{$flow['items'][$i]['text']} \n";
                $body .= "{$items[$i]['value']} \n\n";
            }

            $result = $s3client->putObject(array(
                'Bucket' => 'ysl-plan-entries',
                'Key'    => $flow['title'] . '_' . date('m-d-Y-h-i-s-A').'.txt',
                'Body'   => $body
            ));
        }
        catch(Exception $e) {
			error_log($e);
        }
        
    }

}
