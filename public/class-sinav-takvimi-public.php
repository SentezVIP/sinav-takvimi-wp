<?php

class Sinav_Takvimi_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            SINAV_TAKVIMI_PLUGIN_URL . 'public/css/sinav-takvimi-public.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            SINAV_TAKVIMI_PLUGIN_URL . 'public/js/sinav-takvimi-public.js',
            array('jquery'),
            $this->version,
            false
        );

        wp_localize_script($this->plugin_name, 'sinav_takvimi_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sinav_takvimi_nonce')
        ));
    }

    public function display_calendar($atts) {
        $atts = shortcode_atts(array(
            'tip' => 'tum'
        ), $atts, 'sinav_takvimi');

        ob_start();
        include_once 'views/public-display.php';
        return ob_get_clean();
    }
} 