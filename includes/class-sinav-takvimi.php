<?php

class Sinav_Takvimi {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'sinav-takvimi';
        $this->version = SINAV_TAKVIMI_VERSION;
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once SINAV_TAKVIMI_PLUGIN_DIR . 'includes/class-sinav-takvimi-loader.php';
        require_once SINAV_TAKVIMI_PLUGIN_DIR . 'admin/class-sinav-takvimi-admin.php';
        require_once SINAV_TAKVIMI_PLUGIN_DIR . 'public/class-sinav-takvimi-public.php';
        
        $this->loader = new Sinav_Takvimi_Loader();
    }

    private function set_locale() {
        load_plugin_textdomain(
            'sinav-takvimi',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }

    private function define_admin_hooks() {
        $plugin_admin = new Sinav_Takvimi_Admin($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
    }

    private function define_public_hooks() {
        $plugin_public = new Sinav_Takvimi_Public($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_shortcode('sinav_takvimi', $plugin_public, 'display_calendar');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
} 