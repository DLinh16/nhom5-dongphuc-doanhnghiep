# Phần TV3 (Mạnh): sản phẩm, báo giá, bảng giá, liên hệ

| File | Nội dung |
|---|---|
| `san-pham.csv` | 10 sản phẩm, 5 danh mục, 3 thuộc tính, MOQ, thời gian sản xuất, giá 3 bậc. Nhập: Sản phẩm → Nhập vào (tick "Cập nhật các sản phẩm hiện có" nếu đã có sản phẩm) |
| `anh-san-pham.zip` | 10 ảnh sản phẩm, đặt tên theo SKU (`CS-001.jpg` ...). Giải nén vào `wp-content/uploads/anhthat/` **trước khi** nhập CSV (CSV trỏ tới `http://localhost/dongphuc/wp-content/uploads/anhthat/`) |
| `bang-gia.html` | Nội dung trang Bảng giá (khối "HTML tùy chỉnh") |
| `lien-he.html` | Nội dung trang Liên hệ: thông tin công ty, bản đồ, form (dùng shortcode của plugin) |
| `tv3-forms.php` | Plugin "must-use": form báo giá/liên hệ, lưu yêu cầu vào menu "Yêu cầu báo giá", tự tạo/cập nhật 3 trang. Chép vào `wp-content/mu-plugins/`, mở wp-admin một lần (chạy lại: `wp-admin/?tv3_setup=1`) |
| `bao-cao-tv3.md` | Đoạn báo cáo: cấu trúc danh mục, bảng giá |

Nút "Yeu cau bao gia" của TV1 trỏ tới trang Liên hệ nên form báo giá nằm ở trang đó.
Nhờ TV1: thêm dấu cho chữ "Yeu cau bao gia", "Lien he de nhan bao gia" trong functions.php.
