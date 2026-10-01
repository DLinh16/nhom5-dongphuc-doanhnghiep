<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* =====================================================
 * 1. NAP CSS CHO CHILD THEME
 * ===================================================== */
add_action( 'wp_enqueue_scripts', 'nhom5_enqueue_styles' );
function nhom5_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ), wp_get_theme()->get( 'Version' ) );
}

/* =====================================================
 * 2. SHORTCODE [thong_bao]
 * Cach dung: [thong_bao loai="success" noidung="Noi dung"]
 * Ky thuat an toan: sanitize, validate, escape
 * ===================================================== */
add_shortcode( 'thong_bao', 'nhom5_thong_bao_shortcode' );
function nhom5_thong_bao_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'loai'    => 'info',
        'noidung' => 'Xin chao!',
    ), $atts, 'thong_bao' );

    // [1] SANITIZATION: loc du lieu dau vao
    $noidung = sanitize_text_field( $atts['noidung'] );
    $loai    = sanitize_key( $atts['loai'] );

    // [2] VALIDATION: chi chap nhan gia tri trong danh sach cho phep
    $allowed = array( 'info', 'success', 'warning' );
    if ( ! in_array( $loai, $allowed, true ) ) {
        $loai = 'info';
    }

    // [3] ESCAPING: ma hoa du lieu dau ra, chong XSS
    return '<div class="nhom5-notice nhom5-' . esc_attr( $loai ) . '">'
         . esc_html( $noidung )
         . '</div>';
}

/* =====================================================
 * 3. NUT BACK-TO-TOP (JS tu viet)
 * ===================================================== */
add_action( 'wp_footer', 'nhom5_back_to_top' );
function nhom5_back_to_top() {
    ?>
    <button id="nhom5-btt" type="button"
        aria-label="<?php echo esc_attr__( 'Len dau trang', 'astra-child' ); ?>">&#8593;</button>
    <script>
    (function () {
        var btn = document.getElementById('nhom5-btt');
        if (!btn) return;
        window.addEventListener('scroll', function () {
            btn.classList.toggle('show', window.scrollY > 300);
        });
        btn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
    </script>
    <?php
}

/* =====================================================
 * 4. HARDENING: AN PHIEN BAN WORDPRESS
 * ===================================================== */
remove_action( 'wp_head', 'wp_generator' );
/* =====================================================
 * 5. WOOCOMMERCE CATALOG MODE (chi trung bay, khong ban)
 * ===================================================== */

// An nut "Them vao gio hang"
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// San pham khong the mua
add_filter( 'woocommerce_is_purchasable', '__return_false' );

// Nut "Yeu cau bao gia" tro toi trang Lien he
add_action( 'woocommerce_single_product_summary', 'nhom5_nut_bao_gia', 30 );
function nhom5_nut_bao_gia() {
    $url = esc_url( home_url( '/lien-he/' ) );
    echo '<a class="button nhom5-btn-baogia" href="' . $url . '">'
       . esc_html__( 'Yeu cau bao gia', 'astra-child' )
       . '</a>';
}

// Gio hang, thanh toan: chuyen ve trang chu
add_action( 'template_redirect', 'nhom5_chan_cart_checkout' );
function nhom5_chan_cart_checkout() {
    if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() ) ) {
        wp_safe_redirect( home_url( '/' ) );
        exit;
    }
}
add_filter( 'woocommerce_get_price_html', 'nhom5_an_gia' );
function nhom5_an_gia( $price ) {
    return esc_html__( 'Lien he de nhan bao gia', 'astra-child' );
}