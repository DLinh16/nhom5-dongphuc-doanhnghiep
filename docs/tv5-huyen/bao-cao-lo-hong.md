

\# BÁO CÁO KIỂM TRA VÀ XỬ LÝ LỖ HỔNG WORDPRESS — TV5 HUYỀN



\## 1. Thông tin kiểm tra



\- Website thực hành: `http://localhost/dongphuc-tv5-final/`

\- Công cụ: Wordfence và OWASP ZAP.

\- Mục tiêu: ghi nhận cảnh báo, cập nhật thành phần có phiên bản mới và kiểm tra lại sau xử lý.

\- Phạm vi: website thực hành `dongphuc-tv5-final`, không áp dụng thay đổi lên website gốc `dongphuc`.



\## 2. Bảng báo cáo lỗ hổng



| STT | Thành phần | Phát hiện ban đầu | Mức độ | Cách xử lý / trạng thái |

|---|---|---|---|---|

| 1 | Plugin - Simply Schedule Appointments | Phiên bản 1.6.12.33, Wordfence thông báo có bản 1.6.12.37 | High (theo cảnh báo ban đầu) | Đã cập nhật lên 1.6.12.37; website thực hành mở bình thường sau cập nhật. |

| 2 | Plugin - Joinchat | Phiên bản 6.4.1, Wordfence thông báo có bản 6.4.2 | Medium (theo cảnh báo ban đầu) | Đã cập nhật lên 6.4.2. |

| 3 | Theme - Astra | Phiên bản 4.14.0, Wordfence thông báo có bản 4.14.1 | Medium (theo cảnh báo ban đầu) | Đã cập nhật giao diện cha Astra; giữ nguyên Astra Child. |

| 4 | WordPress Core - `wp-includes/version.php` | Wordfence báo tệp lõi đã bị sửa đổi | Chưa xác định | Chưa ghi nhận là đã khắc phục. Cần đối chiếu tệp với bộ WordPress chính thức đúng phiên bản trước khi sửa hoặc thay thế. |



\*Lưu ý: Mức độ trong bảng dựa trên cảnh báo Wordfence đã ghi nhận trước đó; cần đối chiếu kết quả hiện tại để xác nhận lại.\*



\## 3. Kết quả sau xử lý



\- Simply Schedule Appointments: đã cập nhật từ 1.6.12.33 lên 1.6.12.37.

\- Joinchat: đã cập nhật từ 6.4.1 lên 6.4.2.

\- Astra: đã cập nhật giao diện cha.

\- Website thực hành đã được mở kiểm tra và hiển thị bình thường sau các cập nhật.

\- Đã chạy lại OWASP ZAP và lưu ảnh kết quả.

\- Wordfence vẫn gặp tình trạng mục “Thay đổi tệp” không hoàn tất, trạng thái hiển thị “Cập nhật trạng thái đã tạm dừng”. Vì vậy chưa xác nhận được toàn bộ quá trình quét lại bằng Wordfence đã hoàn tất.



\## 4. Minh chứng



Các ảnh minh chứng được lưu tại thư mục cục bộ:



`D:\\MINH CHỨNG\\GiaiDoan2\\`



Các thư mục liên quan:

\- `11-Hardening`: minh chứng cấu hình bảo mật.

\- `12-OWASP-ZAP`: minh chứng quét bằng OWASP ZAP.

\- `14-SauXuLy`: minh chứng cập nhật thành phần và quét lại sau xử lý.



\## 5. Công việc cần tiếp tục



1\. Xác minh tính toàn vẹn của `wp-includes/version.php` bằng nguồn WordPress chính thức đúng phiên bản.

2\. Kiểm tra lại cảnh báo OWASP ZAP và Wordfence khi công cụ hoạt động ổn định.

3\. Chỉ kết luận lỗ hổng đã khắc phục sau khi có kết quả kiểm tra xác nhận.



\---

Báo cáo thực hiện: TV5 Huyền



