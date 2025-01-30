<?php
/**
 * Plugin Name: Sınav Takvimi
 * Plugin URI: https://www.sentezedu.net
 * Description: Sentez Eğitim için özel geliştirilmiş sınav takvimi eklentisi
 * Version: 1.0.0
 * Author: Sentez Eğitim
 * Author URI: https://www.sentezedu.net
 * License: GPL v2 or later
 * Text Domain: sinav-takvimi
 */

if (!defined('ABSPATH')) {
    exit;
}

// Plugin sabitleri
define('SINAV_TAKVIMI_VERSION', '1.0.0');
define('SINAV_TAKVIMI_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SINAV_TAKVIMI_PLUGIN_URL', plugin_dir_url(__FILE__));

// Gerekli dosyaları dahil et
require_once SINAV_TAKVIMI_PLUGIN_DIR . 'includes/class-sinav-takvimi.php';
require_once SINAV_TAKVIMI_PLUGIN_DIR . 'includes/class-sinav-takvimi-activator.php';
require_once SINAV_TAKVIMI_PLUGIN_DIR . 'includes/class-sinav-takvimi-deactivator.php';

// Aktivasyon ve deaktivasyon kancaları
register_activation_hook(__FILE__, array('Sinav_Takvimi_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('Sinav_Takvimi_Deactivator', 'deactivate'));

// Eklentiyi başlat
function run_sinav_takvimi() {
    $plugin = new Sinav_Takvimi();
    $plugin->run();
}
run_sinav_takvimi(); 