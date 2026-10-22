# BÁO CÁO KIỂM TRA VÀ XỬ LÝ LỖ HỔNG WORDPRESS — TV5 HUYỀN

## 1. Thông tin kiểm tra

- **Website thực hành:** `http://localhost/dongphuc-tv5-final/`
- **Công cụ kiểm tra:** Wordfence và OWASP ZAP.
- **Mục tiêu:** Ghi nhận cảnh báo, cập nhật thành phần có phiên bản mới và kiểm tra lại sau xử lý.
- **Phạm vi:** Chỉ thực hiện trên website thực hành `dongphuc-tv5-final`, không áp dụng thay đổi lên website gốc `dongphuc`.

## 2. Bảng báo cáo lỗ hổng

| STT | Thành phần | Phát hiện ban đầu | Mức độ | Cách xử lý / trạng thái |
| --- | --- | --- | --- | --- |
| 1 | Plugin - Simply Schedule Appointments | Phiên bản 1.6.12.33; Wordfence thông báo có bản 1.6.12.37 | High (theo cảnh báo ban đầu) | Đã cập nhật lên 1.6.12.37. Website thực hành mở bình thường sau cập nhật. |
| 2 | Plugin - Joinchat | Phiên bản 6.4.1; Wordfence thông báo có bản 6.4.2 | Medium (theo cảnh báo ban đầu) | Đã cập nhật lên 6.4.2. |
| 3 | Theme - Astra | Phiên bản 4.14.0; Wordfence thông báo có bản 4.14.1 | Medium (theo cảnh báo ban đầu) | Đã cập nhật theme Astra cha; giữ nguyên Astra Child. |
| 4 | WordPress Core - `wp-includes/version.php` | Wordfence báo tệp lõi đã bị sửa đổi | Chưa xác định | Chưa xác nhận đã khắc phục. Cần đối chiếu tệp với bộ WordPress chính thức đúng phiên bản trước khi sửa hoặc thay thế. |

**Lưu ý:** Mức độ trong bảng dựa trên cảnh báo Wordfence đã ghi nhận trước đó. Cần kiểm tra lại để xác nhận mức độ và trạng thái hiện tại.

## 3. Kết quả sau xử lý

### 3.1. Cập nhật thành phần

- **Simply Schedule Appointments:** Đã cập nhật từ phiên bản 1.6.12.33 lên 1.6.12.37.
- **Joinchat:** Đã cập nhật từ phiên bản 6.4.1 lên 6.4.2.
- **Astra:** Đã cập nhật theme cha; giữ nguyên theme con Astra Child.
- **Kiểm tra website:** Website thực hành đã được mở kiểm tra và hiển thị bình thường sau các cập nhật.

### 3.2. Quét lại sau xử lý

- **OWASP ZAP:** Đã chạy lại quá trình quét và lưu ảnh kết quả.
- **Wordfence:** Mục “Thay đổi tệp” chưa hoàn tất và hiển thị trạng thái “Cập nhật trạng thái đã tạm dừng”. Vì vậy, chưa thể xác nhận toàn bộ quá trình quét lại bằng Wordfence đã hoàn tất.
- **Tệp lõi WordPress:** Cảnh báo liên quan đến `wp-includes/version.php` chưa được xác minh và chưa ghi nhận là đã khắc phục.

## 4. Minh chứng

Các ảnh minh chứng được lưu tại thư mục:

`D:\MINH CHỨNG\GiaiDoan2\`

Các thư mục minh chứng liên quan:

- **`11-Hardening`:** Minh chứng cấu hình bảo mật.
- **`12-OWASP-ZAP`:** Minh chứng quét bằng OWASP ZAP.
- **`14-SauXuLy`:** Minh chứng cập nhật thành phần và quét lại sau xử lý.

## 5. Công việc cần tiếp tục

1. Đối chiếu `wp-includes/version.php` với bộ WordPress chính thức đúng phiên bản để xác minh tính toàn vẹn của tệp.
2. Kiểm tra lại cảnh báo và kết quả quét của Wordfence, OWASP ZAP khi công cụ hoạt động ổn định.
3. Chỉ kết luận một vấn đề đã được khắc phục khi có kết quả kiểm tra xác nhận.

---

**Người thực hiện:** TV5 Huyền
