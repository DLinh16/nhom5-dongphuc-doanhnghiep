<?php
/**
 * Plugin Name: TV3 Forms
 * Description: Form báo giá + liên hệ, không cần plugin ngoài. Yêu cầu của khách lưu trong mục "Yêu cầu báo giá" ở menu quản trị.
 * Version: 1.0
 */
if (!defined('ABSPATH')) { exit; }

define('TV3_MAIL_TO', 'baogia@example.com');

/* ---------- 1. Nơi lưu yêu cầu ---------- */
add_action('init', function () {
  register_post_type('tv3_yeu_cau', array(
    'labels' => array('name' => 'Yêu cầu báo giá', 'singular_name' => 'Yêu cầu', 'menu_name' => 'Yêu cầu báo giá', 'all_items' => 'Tất cả yêu cầu', 'edit_item' => 'Xem yêu cầu'),
    'public' => false,
    'show_ui' => true,
    'menu_icon' => 'dashicons-email-alt',
    'menu_position' => 26,
    'supports' => array('title', 'editor'),
    'capabilities' => array('create_posts' => 'do_not_allow'),
    'map_meta_cap' => true,
  ));
});

/* ---------- 2. Hiển thị form ---------- */
function tv3_field($name, $label, $type = 'text', $req = false) {
  return '<label class="tv3-row"><span>' . esc_html($label) . ($req ? ' *' : '') . '</span><input type="' . esc_attr($type) . '" name="' . esc_attr($name) . '"' . ($req ? ' required' : '') . '></label>';
}
function tv3_select($name, $label, $options, $req = false) {
  $o = $req ? '<option value="">-- Chọn --</option>' : '';
  foreach ($options as $v) { $o .= '<option value="' . esc_attr($v) . '">' . esc_html($v) . '</option>'; }
  return '<label class="tv3-row"><span>' . esc_html($label) . ($req ? ' *' : '') . '</span><select name="' . esc_attr($name) . '"' . ($req ? ' required' : '') . '>' . $o . '</select></label>';
}
function tv3_textarea($name, $label, $req = false) {
  return '<label class="tv3-row"><span>' . esc_html($label) . ($req ? ' *' : '') . '</span><textarea name="' . esc_attr($name) . '" rows="5"' . ($req ? ' required' : '') . '></textarea></label>';
}

add_shortcode('tv3_form', function ($atts) {
  $a = shortcode_atts(array('type' => 'quote'), $atts);
  $type = ($a['type'] === 'contact') ? 'contact' : 'quote';

  $msg = '';
  if (isset($_GET['tv3'])) {
    $ok = ($_GET['tv3'] === 'ok');
    $msg = '<div class="tv3-msg ' . ($ok ? 'tv3-ok' : 'tv3-err') . '">'
      . ($ok ? 'Cảm ơn bạn! Chúng tôi đã nhận được thông tin và sẽ phản hồi trong vòng 24 giờ làm việc.' : 'Gửi chưa thành công, vui lòng kiểm tra lại các ô bắt buộc.')
      . '</div>';
  }

  $css = '.tv3-form{max-width:720px;--c:#1F3864}'
    . '.tv3-row{display:block;margin:0 0 14px}.tv3-row span{display:block;font-weight:600;margin-bottom:4px}'
    . '.tv3-form input[type=text],.tv3-form input[type=tel],.tv3-form input[type=email],.tv3-form input[type=date],.tv3-form select,.tv3-form textarea{width:100%;padding:10px;border:1px solid #c6cbd6;border-radius:6px;box-sizing:border-box;font:inherit}'
    . '.tv3-form h3{color:var(--c);margin:18px 0 10px}.tv3-inline{display:inline-block;margin-right:16px;font-weight:400}'
    . '.tv3-btn{background:var(--c);color:#fff;border:0;padding:12px 24px;border-radius:6px;font-weight:600;cursor:pointer}'
    . '.tv3-msg{padding:12px 14px;border-radius:6px;margin-bottom:16px}.tv3-ok{background:#e6f4ea;color:#14532d}.tv3-err{background:#fdecea;color:#7f1d1d}';

  $h = '<style>' . $css . '</style><div class="tv3-form" id="tv3-form">' . $msg;
  $h .= '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" enctype="multipart/form-data">';
  $h .= '<input type="hidden" name="action" value="tv3_submit"><input type="hidden" name="tv3_type" value="' . esc_attr($type) . '">';
  $h .= wp_nonce_field('tv3_submit', 'tv3_nonce', true, false);
  $h .= '<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">';

  if ($type === 'quote') {
    $h .= '<h3>Thông tin doanh nghiệp</h3>';
    $h .= tv3_field('ten_cong_ty', 'Tên công ty', 'text', true);
    $h .= tv3_field('nguoi_lien_he', 'Người liên hệ', 'text', true);
    $h .= tv3_field('so_dien_thoai', 'Số điện thoại', 'tel', true);
    $h .= tv3_field('email', 'Email', 'email', true);
    $h .= '<h3>Nhu cầu đồng phục</h3>';
    $h .= tv3_select('nhom_san_pham', 'Nhóm sản phẩm quan tâm', array('Đồng phục công sở', 'Áo polo / áo thun', 'Bảo hộ lao động', 'Đồng phục nhà hàng - khách sạn', 'Đồng phục y tế', 'Khác'), true);
    $h .= tv3_field('san_pham', 'Sản phẩm cụ thể (mã hoặc tên, nếu có)');
    $h .= tv3_select('so_luong', 'Số lượng dự kiến', array('50 - 99 bộ', '100 - 499 bộ', 'Từ 500 bộ', 'Chưa xác định'), true);
    $h .= '<div class="tv3-row"><span>Có in hoặc thêu logo không?</span>';
    foreach (array('Có thêu logo', 'Có in logo', 'Không cần') as $i => $v) {
      $h .= '<label class="tv3-inline"><input type="radio" name="logo" value="' . esc_attr($v) . '"' . ($i === 0 ? ' checked' : '') . '> ' . esc_html($v) . '</label>';
    }
    $h .= '</div>';
    $h .= '<label class="tv3-row"><span>Tải logo hoặc mẫu thiết kế (JPG, PNG, PDF, tối đa 5MB)</span><input type="file" name="file_logo" accept=".jpg,.jpeg,.png,.pdf"></label>';
    $h .= tv3_field('ngay_can_hang', 'Thời gian cần nhận hàng', 'date');
    $h .= tv3_textarea('ghi_chu', 'Ghi chú thêm');
  } else {
    $h .= tv3_field('ho_ten', 'Họ tên', 'text', true);
    $h .= tv3_field('ten_cong_ty', 'Công ty');
    $h .= tv3_field('so_dien_thoai', 'Số điện thoại', 'tel', true);
    $h .= tv3_field('email', 'Email', 'email', true);
    $h .= tv3_textarea('noi_dung', 'Nội dung', true);
  }
  $h .= '<button type="submit" class="tv3-btn">' . ($type === 'quote' ? 'Gửi yêu cầu báo giá' : 'Gửi liên hệ') . '</button></form></div>';
  return $h;
});

/* ---------- 3. Nhận form ---------- */
function tv3_handle() {
  $back = wp_get_referer() ? remove_query_arg('tv3', wp_get_referer()) : home_url('/');
  if (!isset($_POST['tv3_nonce']) || !wp_verify_nonce($_POST['tv3_nonce'], 'tv3_submit')) {
    wp_safe_redirect(add_query_arg('tv3', 'err', $back) . '#tv3-form'); exit;
  }
  if (!empty($_POST['website'])) { wp_safe_redirect($back); exit; }

  $type = (isset($_POST['tv3_type']) && $_POST['tv3_type'] === 'contact') ? 'contact' : 'quote';
  if ($type === 'quote') {
    $fields = array('ten_cong_ty' => 'Tên công ty', 'nguoi_lien_he' => 'Người liên hệ', 'so_dien_thoai' => 'Số điện thoại', 'email' => 'Email', 'nhom_san_pham' => 'Nhóm sản phẩm', 'san_pham' => 'Sản phẩm cụ thể', 'so_luong' => 'Số lượng dự kiến', 'logo' => 'In/thêu logo', 'ngay_can_hang' => 'Ngày cần hàng', 'ghi_chu' => 'Ghi chú');
    $name_key = 'nguoi_lien_he';
  } else {
    $fields = array('ho_ten' => 'Họ tên', 'ten_cong_ty' => 'Công ty', 'so_dien_thoai' => 'Số điện thoại', 'email' => 'Email', 'noi_dung' => 'Nội dung');
    $name_key = 'ho_ten';
  }

  $lines = array();
  $vals = array();
  foreach ($fields as $k => $label) {
    $v = isset($_POST[$k]) ? sanitize_textarea_field(wp_unslash($_POST[$k])) : '';
    $vals[$k] = $v;
    $lines[] = $label . ': ' . $v;
  }
  $email = sanitize_email($vals['email']);
  if (trim($vals[$name_key]) === '' || !is_email($email)) {
    wp_safe_redirect(add_query_arg('tv3', 'err', $back) . '#tv3-form'); exit;
  }

  if ($type === 'quote' && !empty($_FILES['file_logo']['name']) && $_FILES['file_logo']['size'] > 0 && $_FILES['file_logo']['size'] <= 5 * 1024 * 1024) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    $up = wp_handle_upload($_FILES['file_logo'], array('test_form' => false, 'mimes' => array('jpg|jpeg|jpe' => 'image/jpeg', 'png' => 'image/png', 'pdf' => 'application/pdf')));
    if (empty($up['error']) && !empty($up['url'])) { $lines[] = 'Logo/thiết kế: ' . $up['url']; }
  }

  $who = ($vals['ten_cong_ty'] !== '') ? $vals['ten_cong_ty'] : $vals[$name_key];
  $title = ($type === 'quote' ? 'Báo giá' : 'Liên hệ') . ' - ' . $who . ' - ' . current_time('d/m/Y H:i');
  wp_insert_post(wp_slash(array('post_type' => 'tv3_yeu_cau', 'post_status' => 'publish', 'post_title' => $title, 'post_content' => implode("\n", $lines))));

  $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $email);
  @wp_mail(TV3_MAIL_TO, ($type === 'quote' ? '(Yêu cầu báo giá) ' : '(Liên hệ) ') . $who, implode("\n", $lines), $headers);

  wp_safe_redirect(add_query_arg('tv3', 'ok', $back) . '#tv3-form'); exit;
}
add_action('admin_post_nopriv_tv3_submit', 'tv3_handle');
add_action('admin_post_tv3_submit', 'tv3_handle');

/* ---------- 4. Tự tạo/cập nhật các trang (chạy 1 lần khi vào wp-admin) ---------- */
function tv3_upsert_page($title, $slug, $html) {
  $found = get_posts(array('post_type' => 'page', 'title' => $title, 'post_status' => 'any', 'numberposts' => 1));
  $content = "<!-- wp:html -->\n" . $html . "\n<!-- /wp:html -->";
  if ($found) {
    wp_update_post(wp_slash(array('ID' => $found[0]->ID, 'post_content' => $content, 'post_status' => 'publish')));
    return array(get_permalink($found[0]->ID), 'đã cập nhật trang có sẵn');
  }
  $id = wp_insert_post(wp_slash(array('post_type' => 'page', 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'publish', 'post_content' => $content)));
  return array(get_permalink($id), 'đã tạo trang mới');
}

$GLOBALS['tv3_msg'] = '';
add_action('admin_init', function () {
  if (!current_user_can('manage_options')) { return; }
  if (wp_doing_ajax()) { return; }
  if (basename($_SERVER['PHP_SELF']) === 'admin-post.php') { return; }
  if (get_option('tv3_setup_v1') && !isset($_GET['tv3_setup'])) { return; }

  $html_gia = <<<'TV3EOT'
<style>
.dpv{--dpv-main:#1F3864;--dpv-soft:#EEF2FA;--dpv-line:#d5dbe8;font-family:inherit}
.dpv h2{color:var(--dpv-main);margin:1.2em 0 .4em}
.dpv .wrap{overflow-x:auto}
.dpv table{width:100%;border-collapse:collapse;min-width:620px}
.dpv th{background:var(--dpv-main);color:#fff;padding:10px;text-align:left}
.dpv td{padding:10px;border-bottom:1px solid var(--dpv-line);vertical-align:top}
.dpv tr:nth-child(even) td{background:var(--dpv-soft)}
.dpv small{color:#666}
.dpv .note{background:var(--dpv-soft);border-left:4px solid var(--dpv-main);padding:10px 14px;margin:14px 0}
.dpv .btn{display:inline-block;background:var(--dpv-main);color:#fff;padding:12px 22px;border-radius:6px;text-decoration:none;font-weight:600}
</style>
<div class="dpv">
<h2>Bảng giá đồng phục theo số lượng</h2>
<p>Đơn giá càng giảm khi số lượng đặt càng lớn. Tất cả giá tính theo VNĐ/bộ.</p>
<div class="wrap"><table>
<thead><tr><th>Sản phẩm</th><th>Đặt tối thiểu</th><th>50 - 99 bộ</th><th>100 - 499 bộ</th><th>Từ 500 bộ</th></tr></thead>
<tbody><tr><td>Áo sơ mi nam dài tay<br><small>Đồng phục công sở · CS-001</small></td><td>50 bộ</td><td>185.000đ</td><td>170.000đ</td><td>155.000đ</td></tr><tr><td>Vest nữ công sở<br><small>Đồng phục công sở · CS-002</small></td><td>30 bộ</td><td>520.000đ</td><td>480.000đ</td><td>440.000đ</td></tr><tr><td>Áo polo unisex cá sấu<br><small>Áo polo / áo thun · PL-001</small></td><td>50 bộ</td><td>125.000đ</td><td>115.000đ</td><td>105.000đ</td></tr><tr><td>Áo thun cổ tròn đồng phục<br><small>Áo polo / áo thun · PL-002</small></td><td>100 bộ</td><td>85.000đ</td><td>78.000đ</td><td>70.000đ</td></tr><tr><td>Quần áo bảo hộ kaki<br><small>Bảo hộ lao động · BH-001</small></td><td>50 bộ</td><td>290.000đ</td><td>265.000đ</td><td>245.000đ</td></tr><tr><td>Áo phản quang an toàn<br><small>Bảo hộ lao động · BH-002</small></td><td>100 bộ</td><td>65.000đ</td><td>58.000đ</td><td>52.000đ</td></tr><tr><td>Áo bếp hai hàng khuy<br><small>Đồng phục nhà hàng - khách sạn · NH-001</small></td><td>30 bộ</td><td>210.000đ</td><td>195.000đ</td><td>180.000đ</td></tr><tr><td>Tạp dề phục vụ dài<br><small>Đồng phục nhà hàng - khách sạn · NH-002</small></td><td>50 bộ</td><td>95.000đ</td><td>88.000đ</td><td>80.000đ</td></tr><tr><td>Bộ scrub y tế cổ chữ V<br><small>Đồng phục y tế · YT-001</small></td><td>30 bộ</td><td>245.000đ</td><td>225.000đ</td><td>205.000đ</td></tr><tr><td>Áo blouse bác sĩ nữ<br><small>Đồng phục y tế · YT-002</small></td><td>30 bộ</td><td>235.000đ</td><td>215.000đ</td><td>195.000đ</td></tr></tbody></table></div>
<div class="note">Giá chưa bao gồm chi phí thêu/in logo và thuế VAT. Đây là giá tham khảo, báo giá chính thức tùy mẫu mã và số lượng thực tế.</div>
<h2>Dịch vụ gia công</h2>
<div class="wrap"><table>
<thead><tr><th>Dịch vụ</th><th>Đơn vị</th><th>Giá tham khảo</th><th>Điều kiện</th></tr></thead>
<tbody><tr><td>Thêu logo ngực trái (dưới 5cm)</td><td>logo</td><td>18.000đ</td><td>Từ 30 bộ</td></tr><tr><td>Thêu logo cỡ vừa (5-10cm)</td><td>logo</td><td>35.000đ</td><td>Từ 30 bộ</td></tr><tr><td>Phí làm mẫu thêu (một lần)</td><td>lần / mẫu logo</td><td>250.000đ</td><td>Đơn đầu tiên</td></tr><tr><td>In lụa logo 1 màu</td><td>logo</td><td>12.000đ</td><td>Từ 50 bộ</td></tr><tr><td>In chuyển nhiệt (nhiều màu)</td><td>logo</td><td>20.000đ</td><td>Từ 30 bộ</td></tr><tr><td>Phí thiết kế mẫu theo yêu cầu</td><td>lần</td><td>300.000đ</td><td>Miễn phí từ 300 bộ</td></tr><tr><td>May đo theo số đo cá nhân</td><td>bộ</td><td>+25.000đ</td><td>Phụ phí / bộ</td></tr><tr><td>Giao hàng nội thành</td><td>đơn</td><td>Miễn phí</td><td>Từ 50 bộ</td></tr></tbody></table></div>
<p style="margin-top:24px"><a class="btn" href="/yeu-cau-bao-gia/">Yêu cầu báo giá ngay</a></p>
</div>
TV3EOT;
  $html_lh = <<<'TV3EOT'
<style>
.dpc{--dpc-main:#1F3864;--dpc-soft:#EEF2FA;font-family:inherit}
.dpc .grid{display:grid;grid-template-columns:1fr 1fr;gap:28px}
@media(max-width:700px){.dpc .grid{grid-template-columns:1fr}}
.dpc h2{color:var(--dpc-main)}
.dpc .card{background:var(--dpc-soft);padding:20px;border-radius:8px}
.dpc .row{margin:0 0 12px}
.dpc .row strong{display:block;color:var(--dpc-main)}
</style>
<div class="dpc">
<h2>Liên hệ với chúng tôi</h2>
<p>Gửi nhu cầu đồng phục của doanh nghiệp, đội ngũ tư vấn sẽ phản hồi trong vòng 24 giờ làm việc.</p>
<div class="grid">
<div class="card">
<div class="row"><strong>Công ty</strong>Đồng Phục Việt Uniform</div>
<div class="row"><strong>Địa chỉ</strong>Số 10 Phố ABC, Hai Bà Trưng, Hà Nội</div>
<div class="row"><strong>Hotline</strong>0900 000 000</div>
<div class="row"><strong>Email nhận báo giá</strong>baogia@example.com</div>
<div class="row"><strong>Giờ làm việc</strong>Thứ 2 - Thứ 7: 8:00 - 17:30</div>
<div class="row"><strong>Zalo</strong>0900 000 000</div>
</div>
<div>
<!-- Thay id bằng id form Contact Form 7 của bạn (xem file form_cf7.txt) -->
[tv3_form type="quote"]
</div>
</div>
<div style="margin-top:28px"><iframe title="Bản đồ" src="https://www.google.com/maps?q=Qu%E1%BA%ADn%20Hai%20B%C3%A0%20Tr%C6%B0ng%2C%20H%C3%A0%20N%E1%BB%99i&output=embed" width="100%" height="380" style="border:0;border-radius:8px" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
</div>
TV3EOT;

  $quote_html = '<h2>Yêu cầu báo giá đồng phục</h2><p>Điền thông tin dưới đây, chúng tôi sẽ gửi báo giá trong vòng 24 giờ làm việc.</p>[tv3_form type="quote"]';
  $l = tv3_upsert_page('Liên hệ', 'lien-he', $html_lh);
  $q = tv3_upsert_page('Yêu cầu báo giá', 'yeu-cau-bao-gia', $quote_html);
  $gia = str_replace('href="/yeu-cau-bao-gia/"', 'href="' . esc_url($l[0]) . '"', $html_gia);
  $g = tv3_upsert_page('Bảng giá', 'bang-gia', $gia);

  $m = '<strong>TV3: đã cài xong form và các trang.</strong><br>'
     . 'Yêu cầu báo giá: ' . esc_html($q[1]) . ' - <a href="' . esc_url($q[0]) . '">xem</a><br>'
     . 'Bảng giá: ' . esc_html($g[1]) . ' - <a href="' . esc_url($g[0]) . '">xem</a><br>'
     . 'Liên hệ: ' . esc_html($l[1]) . ' - <a href="' . esc_url($l[0]) . '">xem</a><br>'
     . 'Các yêu cầu khách gửi sẽ hiện ở menu bên trái: <em>Yêu cầu báo giá</em>.';

  $GLOBALS['tv3_msg'] = $m;
  update_option('tv3_setup_v1', 1);
});
add_action('admin_notices', function () {
  if (!empty($GLOBALS['tv3_msg'])) { echo '<div class="notice notice-success"><p>' . $GLOBALS['tv3_msg'] . '</p></div>'; }
});
