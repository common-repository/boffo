<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/admin
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Admin_Ajax {

    private $options_prefix = 'boffo_admin_';

    public function get_forms() {
        $data = get_option($this->options_prefix . 'forms', array());

        $forms = $data;

        wp_send_json($forms, 200);
    }

    public function post_form() {
        $forms = get_option($this->options_prefix . 'forms', array());

        $form = self::sanitize_form($_POST['form']);

        if(!isset($form['id']) || empty($form['id'])) {
            $rand = substr(md5(microtime()), rand(0, 26), 8);

            $form['id'] = $rand;

            array_push($forms, $form);
        }
        else {
            $keyToUpdate = 0;

            foreach($forms as $key => $iForm) {
                if ($iForm['id'] == $form['id']) {
                    $keyToUpdate = $key;
                    break;
                }
            }

            $forms[$keyToUpdate] = $form;
        }

        update_option($this->options_prefix . 'forms', $forms);

        wp_send_json($form, 200);
    }

    public function delete_form() {
        $forms = get_option($this->options_prefix . 'forms', array()); 

        $form = $_POST['form'];

        $keyToDelete = 0;

        foreach($forms as $key => $iForm) {
            if ($iForm['id'] == $form['id']) {
                $keyToDelete = $key;
                break;
            }
        }

        unset($forms[$keyToDelete]);
        
        update_option($this->options_prefix . 'forms', $forms);

        wp_send_json($forms, 200);
    }

    protected function sanitize_form($form) {
        $sanitizedForm = array();

        foreach ($form as $key => $value) {
            if($key != 'items') {
                $sanitizedForm[$key] = sanitize_text_field($value);
            } else {
                $sanitizedForm[$key] = self::sanitize_items($form[$key]);
            }
        }
        
        return $sanitizedForm;
    }

    protected function sanitize_items($items) {
        $sanitizedItems = array();

        for ($i = 0; $i < count($items); $i++) {
            $sanitizedItems[$i] = array();

            foreach($items[$i] as $key => $value) {
                if($key != 'options') {
                    $sanitizedItems[$i][$key] = sanitize_text_field($value);
                } else {
                    $sanitizedItems[$i][$key] = self::sanitize_options($items[$i][$key]);
                }
            }
        }

        return $sanitizedItems;
    }

    protected function sanitize_options($options) {
        $sanitizedOptions = array();

        for ($i = 0; $i < count($options); $i++) {
            $sanitizedOptions[$i] = array();

            foreach ($options[$i] as $key => $value) {
                $sanitizedOptions[$i][$key] = sanitize_text_field($value);
            }
        }

        return $sanitizedOptions;
    }

}
