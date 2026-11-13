<?php
/**
 * WordPress için başlangıç ayar dosyası.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * Bu dosya şu ayarları içerir:
 * 
 * * Veritabanı ayarları
 * * Gizli anahtarlar
 * * Veritabanı tablo ön eki
 * * ABSPATH
 * 
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Veritabanı ayarları - Bu bilgileri servis sağlayıcınızdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define( 'DB_NAME', 'nova_teknoloji' );

/** Veritabanı kullanıcısı */
define( 'DB_USER', 'root' );

/** Veritabanı parolası */
define( 'DB_PASSWORD', '' );

/** Veritabanı sunucusu */
define( 'DB_HOST', 'localhost' );

/** Yaratılacak tablolar için veritabanı karakter seti. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define( 'DB_COLLATE', '' );

/**#@+
 * Eşsiz doğrulama anahtarları ve tuzlar.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * 
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz.
 * Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-lddm#n>sfE*: S:Cz(2Tzjn]iK_SqFRzD>j^Ji-iK>ae09?I7Nn_vOgF(._uN^ ' );
define( 'SECURE_AUTH_KEY',  '3)Z_@hUq+oJ6BlI=LJ#I>=W?S=eD[< ~{Hn%N3r.t#F$S8Qq+sX#(~Sd?PffmTod' );
define( 'LOGGED_IN_KEY',    'D)zI^9{nAal-&b ;+yomr?Z|+_a=<j(+s!vpvgSI6<YPgc0(_G@y4G.S,g,?vZUo' );
define( 'NONCE_KEY',        '.b*gO>>LooUNSS@nJ+E!o>vH:~O7L*kNeyz_j}/~N|{6Kx|^uDc<G),S*L@9%w-)' );
define( 'AUTH_SALT',        'gJNGqH$3O;QU77LaZh,ZlcR/33Btaqh^{KJj%U#=&X}:oxrz$-[moenIQQrM`/rI' );
define( 'SECURE_AUTH_SALT', 'CvNTRy8P17FNtTn|_3cO~IB>NwvC[P8?H@+-55^qhcv=9:J/n$-XjAoIA39WO0-S' );
define( 'LOGGED_IN_SALT',   '4!:~~m%I31Go#:q/gG3R7xw[F-bB4z6eM=`!wdsf}Z@KKyWEgxGC_X-re*nW]YH(' );
define( 'NONCE_SALT',       'yU;dB(-$}-A5,/(zM^]xhd]mBHN>Ui=tKouf9;K3hyKupuSesXkmF)e>I.I%]p1]' );

/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 *
 * Kurulum sırasında veritabanı tabloları belirtilen önek ile oluşturulur. 
 * WordPress kurulduktan sonra bu değeri değiştirmek, sitenin kurulmamış
 * olduğunu düşünmesine neden olur.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri true olarak ayarlayıp geliştirme sırasında hataların ekrana
 * basılmasını sağlayabilirsiniz. Tema ve eklenti geliştiricilerinin geliştirme
 * aşamasında WP_DEBUG kullanmalarını önemle tavsiye ederiz.
 * 
 * Hata ayıklama için kullanabilecek diğer sabitler ile ilgili daha fazla bilgiyi
 * belgelerden edinebilirsiniz.
 * 
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Her türlü özel değeri bu satı ile "Hepsi bu kadar" yazan satır arasına ekleyebilirsiniz. */



/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** WordPress değişkenlerini ve yollarını kurar. */
require_once ABSPATH . 'wp-settings.php';