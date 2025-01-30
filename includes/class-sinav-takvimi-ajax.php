<?php

class Sinav_Takvimi_Ajax {
    public function __construct() {
        add_action('wp_ajax_sinav_takvimi_kaydet', array($this, 'kaydet'));
        add_action('wp_ajax_sinav_takvimi_listele', array($this, 'listele'));
        add_action('wp_ajax_sinav_takvimi_sil', array($this, 'sil'));
        
        // Public AJAX
        add_action('wp_ajax_nopriv_sinav_takvimi_listele', array($this, 'listele'));
    }

    public function kaydet() {
        check_ajax_referer('sinav_takvimi_nonce', '_wpnonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Yetkiniz yok!'));
        }

        $data = array(
            'sinav_duzeyi' => sanitize_text_field($_POST['sinav_duzeyi']),
            'sinav_turu' => sanitize_text_field($_POST['sinav_turu']),
            'tarih_saat' => sanitize_text_field($_POST['tarih_saat']),
            'sure' => absint($_POST['sure']),
            'notlar' => sanitize_textarea_field($_POST['notlar'])
        );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sinav_takvimi';
        
        $result = $wpdb->insert(
            $table_name,
            $data,
            array('%s', '%s', '%s', '%d', '%s')
        );

        if ($result === false) {
            wp_send_json_error(array('message' => 'Veritabanı hatası!'));
        }

        wp_send_json_success(array('message' => 'Sınav başarıyla kaydedildi.'));
    }

    public function listele() {
        check_ajax_referer('sinav_takvimi_nonce', '_wpnonce');

        global $wpdb;
        $table_name = $wpdb->prefix . 'sinav_takvimi';
        
        $sinavlar = $wpdb->get_results(
            "SELECT * FROM $table_name ORDER BY tarih_saat ASC"
        );

        wp_send_json_success($sinavlar);
    }

    public function sil() {
        check_ajax_referer('sinav_takvimi_nonce', '_wpnonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Yetkiniz yok!'));
        }

        $id = absint($_POST['id']);
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'sinav_takvimi';
        
        $result = $wpdb->delete(
            $table_name,
            array('id' => $id),
            array('%d')
        );

        if ($result === false) {
            wp_send_json_error(array('message' => 'Veritabanı hatası!'));
        }

        wp_send_json_success(array('message' => 'Sınav başarıyla silindi.'));
    }
} 