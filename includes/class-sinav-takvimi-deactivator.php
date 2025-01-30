<?php

class Sinav_Takvimi_Deactivator {
    public static function deactivate() {
        // Eklenti deaktive edildiğinde yapılacak işlemler
        delete_option('sinav_takvimi_version');
        
        // NOT: Veritabanı tablolarını silmiyoruz
        // Kullanıcı verileri korunsun
    }
} 