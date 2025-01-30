<?php

class Sinav_Takvimi_Activator {
    public static function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'sinav_takvimi';
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            sinav_duzeyi varchar(50) NOT NULL,
            sinav_turu text NOT NULL,
            tarih_saat datetime NOT NULL,
            sure int(11) NOT NULL,
            notlar text,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        add_option('sinav_takvimi_version', SINAV_TAKVIMI_VERSION);
    }
} 