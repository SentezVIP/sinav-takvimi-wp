# Sınav Takvimi WordPress Eklentisi

Sentez Eğitim için özel olarak geliştirilmiş WordPress sınav takvimi eklentisi.

## Özellikler

- YKS, LGS, 11. Sınıf, 7. Sınıf ve Bursluluk sınavları için takvim yönetimi
- Modern ve kullanıcı dostu arayüz
- Responsive tasarım
- Sınav filtreleme özelliği
- Kolay kurulum ve kullanım
- AJAX tabanlı işlemler
- Güvenli veri yönetimi

## Kurulum

1. ZIP dosyasını indirin
2. WordPress yönetici panelinden "Eklentiler > Yeni Ekle > Eklenti Yükle" menüsüne gidin
3. ZIP dosyasını yükleyin ve etkinleştirin
4. Sol menüde "Sınav Takvimi" seçeneği görünecektir

## Kullanım

### Yönetici Paneli

1. WordPress yönetici panelinde "Sınav Takvimi" menüsüne tıklayın
2. "Yeni Sınav Ekle" formunu kullanarak sınav ekleyin
3. Eklenen sınavları listeden görüntüleyin, düzenleyin veya silin

### Ziyaretçi Görünümü

Takvimi sayfalarınızda göstermek için kısa kodları kullanın:

- Tüm sınavları göstermek için: `[sinav_takvimi]`
- Sadece yaklaşan sınavları göstermek için: `[sinav_takvimi tip="yaklasan"]`

## Özelleştirme

Tema renkleri ve stilleri CSS değişkenleri ile özelleştirilebilir:

```css
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
```

## Gereksinimler

- WordPress 5.0 veya üzeri
- PHP 7.4 veya üzeri
- MySQL 5.6 veya üzeri

## Güvenlik

- Nonce doğrulaması
- Kullanıcı yetkilendirmesi
- XSS koruması
- SQL enjeksiyon koruması
- Veri sanitizasyonu

## Destek

Teknik destek ve özellik istekleri için:
- E-posta: info@sentezedu.net
- Web: www.sentezedu.net

## Lisans

GPL v2 veya üzeri 