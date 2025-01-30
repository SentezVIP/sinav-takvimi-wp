<?php
if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>Sınav Takvimi Yönetimi</h1>
    
    <div class="card">
        <h2>Yeni Sınav Ekle</h2>
        <form id="sinav-ekle-form">
            <?php wp_nonce_field('sinav_takvimi_action', 'sinav_takvimi_nonce'); ?>
            
            <div class="form-group">
                <label for="sinav_duzeyi">Sınav Düzeyi:</label>
                <select name="sinav_duzeyi" id="sinav_duzeyi" required>
                    <option value="">Seçiniz</option>
                    <option value="YKS">YKS</option>
                    <option value="LGS">LGS</option>
                    <option value="11_SINIF">11. Sınıf</option>
                    <option value="7_SINIF">7. Sınıf</option>
                    <option value="BURSLULUK">Bursluluk</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="sinav_turu">Sınav Türü:</label>
                <input type="text" name="sinav_turu" id="sinav_turu" required>
            </div>
            
            <div class="form-group">
                <label for="tarih_saat">Tarih ve Saat:</label>
                <input type="datetime-local" name="tarih_saat" id="tarih_saat" required>
            </div>
            
            <div class="form-group">
                <label for="sure">Süre (Dakika):</label>
                <input type="number" name="sure" id="sure" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="notlar">Notlar:</label>
                <textarea name="notlar" id="notlar" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="button button-primary">Sınavı Kaydet</button>
            </div>
        </form>
    </div>
    
    <div class="card">
        <h2>Sınav Listesi</h2>
        <div id="sinav-listesi">
            <!-- AJAX ile doldurulacak -->
        </div>
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

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: var(--text-color);
    font-weight: 500;
}

.form-group input[type="text"],
.form-group input[type="datetime-local"],
.form-group input[type="number"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    outline: none;
}

.button-primary {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.button-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

#sinav-listesi {
    margin-top: 20px;
}

.sinav-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.sinav-item:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.3s ease-out forwards;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Form gönderimi
    $('#sinav-ekle-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('action', 'sinav_takvimi_kaydet');
        
        $.ajax({
            url: sinav_takvimi_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', sinav_takvimi_ajax.nonce);
            },
            success: function(response) {
                if (response.success) {
                    alert('Sınav başarıyla kaydedildi!');
                    $('#sinav-ekle-form')[0].reset();
                    loadSinavlar();
                } else {
                    alert('Hata: ' + response.data.message);
                }
            },
            error: function() {
                alert('Bir hata oluştu!');
            }
        });
    });
    
    // Sınavları yükle
    function loadSinavlar() {
        $.ajax({
            url: sinav_takvimi_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'sinav_takvimi_listele',
                _wpnonce: sinav_takvimi_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var html = '';
                    response.data.forEach(function(sinav) {
                        html += '<div class="sinav-item fade-in">';
                        html += '<h3>' + sinav.sinav_duzeyi + ' - ' + sinav.sinav_turu + '</h3>';
                        html += '<p>Tarih: ' + sinav.tarih_saat + '</p>';
                        html += '<p>Süre: ' + sinav.sure + ' dakika</p>';
                        if (sinav.notlar) {
                            html += '<p>Notlar: ' + sinav.notlar + '</p>';
                        }
                        html += '<button class="button" onclick="deleteSinav(' + sinav.id + ')">Sil</button>';
                        html += '</div>';
                    });
                    $('#sinav-listesi').html(html);
                }
            }
        });
    }
    
    // Sayfa yüklendiğinde sınavları getir
    loadSinavlar();
});

// Sınav silme fonksiyonu
function deleteSinav(id) {
    if (confirm('Bu sınavı silmek istediğinizden emin misiniz?')) {
        jQuery.ajax({
            url: sinav_takvimi_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'sinav_takvimi_sil',
                id: id,
                _wpnonce: sinav_takvimi_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    alert('Sınav başarıyla silindi!');
                    loadSinavlar();
                } else {
                    alert('Hata: ' + response.data.message);
                }
            }
        });
    }
}
</script> 