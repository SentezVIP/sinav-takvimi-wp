<?php
if (!defined('ABSPATH')) exit;

global $wpdb;
$table_name = $wpdb->prefix . 'sinav_takvimi';

// Sınavları getir
$where = '';
if ($atts['tip'] === 'yaklasan') {
    $where = $wpdb->prepare(" WHERE tarih_saat >= %s", current_time('mysql'));
}

$sinavlar = $wpdb->get_results(
    "SELECT * FROM $table_name" . $where . " ORDER BY tarih_saat ASC"
);
?>

<div class="sinav-takvimi-container">
    <div class="sinav-filtrele">
        <select id="sinav-duzeyi-filtre">
            <option value="">Tüm Sınavlar</option>
            <option value="YKS">YKS</option>
            <option value="LGS">LGS</option>
            <option value="11_SINIF">11. Sınıf</option>
            <option value="7_SINIF">7. Sınıf</option>
            <option value="BURSLULUK">Bursluluk</option>
        </select>
    </div>

    <div class="sinav-listesi">
        <?php if ($sinavlar): ?>
            <?php foreach ($sinavlar as $sinav): ?>
                <div class="sinav-card" data-duzeyi="<?php echo esc_attr($sinav->sinav_duzeyi); ?>">
                    <div class="sinav-baslik">
                        <h3><?php echo esc_html($sinav->sinav_duzeyi); ?></h3>
                        <span class="sinav-turu"><?php echo esc_html($sinav->sinav_turu); ?></span>
                    </div>
                    
                    <div class="sinav-detay">
                        <div class="tarih-saat">
                            <i class="fas fa-calendar"></i>
                            <?php echo date_i18n('j F Y, l', strtotime($sinav->tarih_saat)); ?>
                        </div>
                        <div class="saat">
                            <i class="fas fa-clock"></i>
                            <?php echo date_i18n('H:i', strtotime($sinav->tarih_saat)); ?>
                        </div>
                        <div class="sure">
                            <i class="fas fa-hourglass-half"></i>
                            <?php echo esc_html($sinav->sure); ?> dakika
                        </div>
                    </div>
                    
                    <?php if (!empty($sinav->notlar)): ?>
                        <div class="sinav-notlar">
                            <i class="fas fa-info-circle"></i>
                            <?php echo esc_html($sinav->notlar); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="sinav-yok">
                <p>Henüz sınav eklenmemiş.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --secondary-color: #f1f5f9;
    --accent-color: #ec4899;
    --success-color: #22c55e;
    --warning-color: #eab308;
    --text-color: #1e293b;
    --text-light: #64748b;
    --background-color: #f8fafc;
}

.sinav-takvimi-container {
    font-family: 'Poppins', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.sinav-filtrele {
    margin-bottom: 30px;
}

.sinav-filtrele select {
    width: 200px;
    padding: 10px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    background-color: white;
    transition: all 0.3s ease;
}

.sinav-filtrele select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    outline: none;
}

.sinav-listesi {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.sinav-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: all 0.3s ease;
}

.sinav-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.sinav-baslik {
    margin-bottom: 15px;
}

.sinav-baslik h3 {
    color: var(--text-color);
    margin: 0 0 5px 0;
    font-size: 1.2em;
}

.sinav-turu {
    color: var(--text-light);
    font-size: 0.9em;
}

.sinav-detay {
    margin-bottom: 15px;
}

.sinav-detay > div {
    margin-bottom: 8px;
    color: var(--text-color);
    display: flex;
    align-items: center;
}

.sinav-detay i {
    margin-right: 8px;
    color: var(--primary-color);
}

.sinav-notlar {
    background: var(--secondary-color);
    padding: 10px;
    border-radius: 8px;
    font-size: 0.9em;
    color: var(--text-light);
}

.sinav-notlar i {
    color: var(--warning-color);
    margin-right: 8px;
}

.sinav-yok {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 12px;
    color: var(--text-light);
}

@media (max-width: 768px) {
    .sinav-listesi {
        grid-template-columns: 1fr;
    }
    
    .sinav-takvimi-container {
        padding: 10px;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.sinav-card {
    animation: fadeInUp 0.5s ease-out forwards;
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#sinav-duzeyi-filtre').on('change', function() {
        var duzeyi = $(this).val();
        
        if (duzeyi === '') {
            $('.sinav-card').show();
        } else {
            $('.sinav-card').hide();
            $('.sinav-card[data-duzeyi="' + duzeyi + '"]').show();
        }
    });
});
</script> 