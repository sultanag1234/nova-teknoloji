<?php
/*
Plugin Name: Dinamik Duyuru Yönetimi
Description: Duyuru ekleme, listeleme, düzenleme ve silme sistemi.
Version: 2.0
Author: Admin
*/

if (!defined('ABSPATH')) {
    exit;
}

// Yönetim menüsü
add_action('admin_menu', function () {
    add_menu_page(
        'Duyuru Yönetimi',
        'Duyurular',
        'manage_options',
        'dinamik-duyurular',
        'duyuru_yonetim_sayfasi',
        'dashicons-megaphone',
        25
    );
});

// Duyuru işlemleri
function duyuru_yonetim_sayfasi() {
    global $wpdb;

    if (!current_user_can('manage_options')) {
        return;
    }

    $tablo = $wpdb->prefix . 'duyurular';

    // Duyuru ekleme
    if (isset($_POST['duyuru_kaydet']) &&
        check_admin_referer('duyuru_islem')) {

        $baslik = sanitize_text_field($_POST['baslik']);
        $icerik = sanitize_textarea_field($_POST['icerik']);

        $wpdb->insert(
            $tablo,
            [
                'baslik' => $baslik,
                'icerik' => $icerik,
                'tarih' => current_time('mysql')
            ],
            ['%s', '%s', '%s']
        );

        echo '<div class="notice notice-success"><p>Duyuru eklendi!</p></div>';
    }

    // Duyuru düzenleme
    if (isset($_POST['duyuru_guncelle']) &&
        check_admin_referer('duyuru_islem')) {

        $id = absint($_POST['id']);

        $wpdb->update(
            $tablo,
            [
                'baslik' => sanitize_text_field($_POST['baslik']),
                'icerik' => sanitize_textarea_field($_POST['icerik'])
            ],
            ['id' => $id],
            ['%s', '%s'],
            ['%d']
        );

        echo '<div class="notice notice-success"><p>Duyuru güncellendi!</p></div>';
    }

    // Duyuru silme
    if (isset($_POST['duyuru_sil']) &&
        check_admin_referer('duyuru_islem')) {

        $id = absint($_POST['id']);

        $wpdb->delete(
            $tablo,
            ['id' => $id],
            ['%d']
        );

        echo '<div class="notice notice-success"><p>Duyuru silindi!</p></div>';
    }

    echo '<div class="wrap">';
    echo '<h1>Duyuru Yönetimi</h1>';

    // Düzenlenecek duyuruyu bul
    $duzenle = null;

    if (isset($_GET['duzenle'])) {
        $id = absint($_GET['duzenle']);

        $duzenle = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $tablo WHERE id = %d",
                $id
            )
        );
    }

    // Form
    if ($duzenle) {
        echo '<h2>Duyuruyu Düzenle</h2>';
    } else {
        echo '<h2>Yeni Duyuru Ekle</h2>';
    }

    echo '<form method="post">';
    wp_nonce_field('duyuru_islem');

    if ($duzenle) {
        echo '<input type="hidden" name="id" value="' . esc_attr($duzenle->id) . '">';
    }

    $baslik = $duzenle ? $duzenle->baslik : '';
    $icerik = $duzenle ? $duzenle->icerik : '';

    echo '<p><input type="text" name="baslik" placeholder="Duyuru Başlığı" required class="regular-text" value="' . esc_attr($baslik) . '"></p>';

    echo '<p><textarea name="icerik" placeholder="Duyuru İçeriği" required rows="5" class="large-text">' . esc_textarea($icerik) . '</textarea></p>';

    if ($duzenle) {
        echo '<p><button type="submit" name="duyuru_guncelle" class="button button-primary">Değişiklikleri Kaydet</button></p>';
    } else {
        echo '<p><button type="submit" name="duyuru_kaydet" class="button button-primary">Duyuru Ekle</button></p>';
    }

    echo '</form>';

    // Duyuruları listele
    echo '<h2>Eklenen Duyurular</h2>';

    $duyurular = $wpdb->get_results(
        "SELECT * FROM $tablo ORDER BY id DESC"
    );

    if ($duyurular) {
        foreach ($duyurular as $duyuru) {
            echo '<div class="card" style="max-width:800px; padding:15px; margin-bottom:15px;">';

            echo '<h3>' . esc_html($duyuru->baslik) . '</h3>';
            echo '<p>' . nl2br(esc_html($duyuru->icerik)) . '</p>';
            echo '<p><strong>Eklenme Tarihi:</strong> ' . esc_html($duyuru->tarih) . '</p>';

            // Düzenleme bağlantısı
            echo '<a class="button" href="' . esc_url(admin_url('admin.php?page=dinamik-duyurular&duzenle=' . $duyuru->id)) . '">Düzenle</a> ';

            // Silme formu
            echo '<form method="post" style="display:inline-block;">';
            wp_nonce_field('duyuru_islem');
            echo '<input type="hidden" name="id" value="' . esc_attr($duyuru->id) . '">';
            echo '<button type="submit" name="duyuru_sil" class="button button-secondary" onclick="return confirm(\'Bu duyuruyu silmek istediğinize emin misiniz?\')">Sil</button>';
            echo '</form>';

            echo '</div>';
        }
    } else {
        echo '<p>Henüz duyuru eklenmemiş.</p>';
    }

    echo '</div>';
}

// Eklenti etkinleştirildiğinde tablo oluştur
register_activation_hook(__FILE__, 'duyuru_tablo_olustur');

function duyuru_tablo_olustur() {
    global $wpdb;

    $tablo = $wpdb->prefix . 'duyurular';

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tablo (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        baslik varchar(255) NOT NULL,
        icerik longtext NOT NULL,
        tarih datetime NOT NULL,
        PRIMARY KEY (id)
    ) $charset;";

    dbDelta($sql);
}