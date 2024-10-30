<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Flow {

	protected static $options_prefix = 'boffo_admin_';

	public static function getFlow($id) {
		$flows = get_option(self::$options_prefix . 'forms', array());

		foreach($flows as $f) {
			if ($f['id'] == $id) {
				return $f;
			}
		}

		return null;
	}

	public static function renderShortCode($attrs) {
		$attributes = shortcode_atts( array(
			'boffo_id' => ''
		), $attrs );

		if(!empty($attributes['boffo_id'])) {
			echo self::renderFlowHtml($attributes['boffo_id']);
		}
	}

	public static function renderBlock($attrs) {
		return self::renderFlowHtml($attrs['boffo_id']);
	}

	public static function renderFlowHtml($boffo_id) {
		$flow = null;
		$flows = get_option(self::$options_prefix . 'forms', array());

		foreach($flows as $f) {
			if ($f['id'] == $boffo_id) {
				$flow = $f;
				break;
			}
		}
		
		if(!empty($flow)) {
			$path = $_SERVER['REQUEST_URI'];

			if(strrpos($path, 'wp-json') > -1) {
				return '<div style="padding: 20px; border: solid 1px #e0e0e0; text-align: center;">Your Boffo flow has been successfully added!</div>';
			}
		
			ob_start(); 
			require dirname(__FILE__) . '/../public/partials/boffo-public-flow.php';
			$renderedForm = ob_get_contents();
			ob_get_clean();

			return $renderedForm;
		}
		else {
			return '<div style="padding: 20px; border: solid 1px #e0e0e0; text-align: center; color: red;">Boffo flow not found.  Please make sure there correct Boffo Flow Id is being used in block settings.</div>';
		}
	}

}
