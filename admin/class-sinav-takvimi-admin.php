<?php

class Sinav_Takvimi_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            SINAV_TAKVIMI_PLUGIN_URL . 'admin/css/sinav-takvimi-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            SINAV_TAKVIMI_PLUGIN_URL . 'admin/js/sinav-takvimi-admin.js',
            array('jquery'),
            $this->version,
            false
        );

        wp_localize_script($this->plugin_name, 'sinav_takvimi_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sinav_takvimi_nonce')
        ));
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'Sınav Takvimi',
            'Sınav Takvimi',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-calendar-alt',
            20
        );
    }

    public function display_plugin_admin_page() {
        include_once 'views/admin-display.php';
    }
} 