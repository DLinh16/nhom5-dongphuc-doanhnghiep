# \# Nhóm 5 – Website cung cấp đồng phục doanh nghiệp B2B

# 

# Website WordPress giới thiệu doanh nghiệp thiết kế – sản xuất – cung cấp đồng phục cho doanh nghiệp, trường học và tổ chức; trình bày sản phẩm, bảng giá và thu thập khách hàng tiềm năng (lead) qua form liên hệ và công cụ đặt lịch tư vấn.

# 

# \## Các trang chính

# 

# Trang chủ · Giới thiệu · Sản phẩm · Bảng giá · Đặt lịch tư vấn · Liên hệ

# 

# \## Công nghệ

# 

# | Thành phần | Chi tiết |

# |---|---|

# | CMS | WordPress 7.1.2 |

# | Theme | Astra (theme cha) + Astra Child - Nhom 5 (tự viết) |

# | PHP / CSDL | PHP \[8.x.x], MySQL/MariaDB \[x.x] |

# | Môi trường | XAMPP (Windows) |

# | Plugin | Xem \[docs/license-table.md](docs/license-table.md) |

# 

# \## Cấu trúc repository

# 

# ```

# ├── wp-content/themes/astra-child/   # Child theme (style.css, functions.php)

# ├── database/nhom5\_dongphuc.sql      # File database (xuất từ phpMyAdmin)

# ├── docs/                            # Báo cáo, ảnh minh chứng, bảng license

# │   ├── license-table.md

# │   └── screenshots/

# ├── .gitignore

# ├── LICENSE                          # GPL v2

# └── README.md

# ```

# 

# > Repo chỉ chứa phần tự phát triển. Lõi WordPress, plugin và thư mục `uploads` không được đưa lên (xem `.gitignore`); `wp-config.php` không được commit vì chứa mật khẩu database.

# 

# \## Hướng dẫn cài đặt

# 

# \### 1. Chuẩn bị

# \- Cài \[XAMPP](https://www.apachefriends.org), bật \*\*Apache\*\* và \*\*MySQL\*\*.

# \- Cài \[Git](https://git-scm.com).

# 

# \### 2. Cài WordPress

# 1\. Tải WordPress \*\*7.1.2\*\*, giải nén vào `C:\\\\xampp\\\\htdocs\\\\dongphuc`.

# 2\. Mở `http://localhost/phpmyadmin`, tạo database trống tên \*\*`wp\\\_dongphuc`\*\* (collation `utf8mb4\\\_unicode\\\_ci`).

# 3\. Truy cập `http://localhost/dongphuc`, chạy trình cài đặt (user `root`, mật khẩu để trống, host `localhost`).

# 

# \### 3. Lấy mã nguồn

# ```bash

# git clone https://github.com/DLinh16/nhom5-dongphuc-doanhnghiep.git

# ```

# Chép thư mục `wp-content/themes/astra-child` vào `C:\\\\xampp\\\\htdocs\\\\dongphuc\\\\wp-content\\\\themes\\\\`.

# 

# \### 4. Cài theme và plugin

# \- \*\*Giao diện → Thêm mới\*\*: cài \*\*Astra\*\* (không cần kích hoạt).

# \- Cài các plugin theo bảng trong `docs/license-table.md`.

# 

# \### 5. Nhập database

# 1\. phpMyAdmin → chọn database `wp\\\_dongphuc` → tab \*\*Nhập (Import)\*\*.

# 2\. Chọn file `database/nhom5\\\_dongphuc.sql` → \*\*Thực hiện\*\*.

# 

# \### 6. Kích hoạt và đăng nhập

# 1\. \*\*Giao diện → Theme\*\* → kích hoạt \*\*Astra Child - Nhom 5\*\*.

# 2\. Đăng nhập `http://localhost/dongphuc/wp-admin` bằng tài khoản demo do nhóm cung cấp riêng. \*\*Không ghi mật khẩu trong repo.\*\*

# 

# \### 7. Nếu địa chỉ site khác `http://localhost/dongphuc`

# Sửa `siteurl` và `home` trong bảng `options` của database, hoặc dùng plugin \*\*Better Search Replace\*\*.

# 

# \## Tính năng tự viết (Child Theme)

# 

# File: `wp-content/themes/astra-child/functions.php` và `style.css`

# 

# | Tính năng | Mô tả |

# |---|---|

# | Shortcode `\\\[thong\\\_bao]` | Hiển thị hộp thông báo. Cú pháp: `\\\[thong\\\_bao loai="success" noidung="Giảm 10% đơn hàng"]`. Loại hợp lệ: `info`, `success`, `warning` |

# | Nút Back-to-top | Nút cuộn lên đầu trang (JS + CSS tự viết), hiện khi cuộn quá 300px |

# | Ẩn phiên bản WordPress | Gỡ thẻ `generator` khỏi `<head>` (hardening) |

# 

# \### Kỹ thuật lập trình an toàn áp dụng

# \- \*\*Sanitization:\*\* `sanitize\\\_text\\\_field()`, `sanitize\\\_key()` lọc dữ liệu đầu vào.

# \- \*\*Validation:\*\* `in\\\_array()` chỉ chấp nhận giá trị trong danh sách cho phép.

# \- \*\*Escaping:\*\* `esc\\\_html()`, `esc\\\_attr()` mã hóa dữ liệu đầu ra, chống XSS.

# 

# \## Bảo mật (System Hardening)

# 

# \[Huyền cập nhật: đổi URL đăng nhập, giới hạn đăng nhập sai, tắt directory browsing, tắt xmlrpc, phân quyền file 644/755/400, plugin bảo mật, kết quả quét WPScan.]

# 

# \## Thành viên và phân công

# 

# | TV | Họ tên | Nhiệm vụ |

# |---|---|---|

# | TV1 | Linh | Database, child theme, functions.php, tích hợp web, tổng hợp code |

# | TV2 | Thanh | Trang chủ, footer, trang giới thiệu (giao diện), menu |

# | TV3 | Mạnh | Sản phẩm, danh mục, chi tiết sản phẩm, bảng giá, liên hệ |

# | TV4 | Nguyên | Đặt lịch tư vấn |

# | TV5 | Huyền | Bảo mật: đổi URL, giới hạn login, chặn duyệt thư mục, quét bảo mật |

# 

# \## Giấy phép

# 

# Mã nguồn tự viết phát hành theo \*\*GPL v2 or later\*\*, tương thích với WordPress. Danh sách theme/plugin và giấy phép từng thành phần: \[docs/license-table.md](docs/license-table.md).

