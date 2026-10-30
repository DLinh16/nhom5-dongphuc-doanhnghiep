# Báo cáo TV3: cấu trúc danh mục và bảng giá (bản nháp, chỉnh lại theo giọng văn của bạn)

## 1. Cấu trúc danh mục sản phẩm

Sản phẩm được tổ chức trong WooCommerce theo **5 danh mục một cấp** (không có danh mục con vì quy mô demo nhỏ), mỗi danh mục tương ứng một nhóm khách hàng doanh nghiệp:

- Đồng phục công sở
- Áo polo / áo thun
- Bảo hộ lao động
- Đồng phục nhà hàng - khách sạn
- Đồng phục y tế

Ba **thuộc tính dùng chung** cho mọi sản phẩm, để thống nhất cách nhập liệu và phục vụ lọc: **Chất liệu**, **Màu sắc**, **Size**.

Vì đây là website B2B, mỗi sản phẩm có thêm các trường riêng: **số lượng đặt tối thiểu** (MOQ), **thời gian sản xuất** (ngày) và **giá theo ba bậc số lượng**. Mã sản phẩm (SKU) đặt theo tiền tố của danh mục (CS, PL, BH, NH, YT). Hiện có 10 sản phẩm mẫu, mỗi danh mục 2 sản phẩm, đều dùng chung một khuôn trang chi tiết: ảnh, tên, mô tả, thông số, bảng giá theo số lượng và nút "Yêu cầu báo giá". Website chạy ở chế độ catalog: không có giỏ hàng hay thanh toán.

## 2. Bảng giá

Đơn giá tính theo bộ (VNĐ) và **giảm dần theo ba bậc số lượng**: 50-99 bộ, 100-499 bộ, từ 500 bộ. Ví dụ áo sơ mi nam dài tay (CS-001): 185.000 đ, 170.000 đ, 155.000 đ. Giá là giá tham khảo, chưa gồm chi phí thêu/in logo và VAT.

Bảng **dịch vụ gia công** đi kèm gồm: thêu logo ngực trái 18.000 đ/logo (từ 30 bộ), thêu logo cỡ vừa 35.000 đ, phí làm mẫu thêu 250.000 đ (tính một lần), in lụa 12.000 đ, in chuyển nhiệt 20.000 đ, thiết kế mẫu theo yêu cầu 300.000 đ (miễn phí từ 300 bộ), may đo theo số đo cá nhân phụ phí 25.000 đ/bộ, giao hàng nội thành miễn phí từ 50 bộ.

## 3. Luồng báo giá và liên hệ

Khách xem sản phẩm, bấm "Yêu cầu báo giá" và đến trang Liên hệ, nơi có thông tin công ty, bản đồ và form gồm: công ty, người liên hệ, số điện thoại, email, nhóm sản phẩm, số lượng dự kiến, in/thêu logo, tải logo (JPG, PNG, PDF tối đa 5MB), ngày cần hàng và ghi chú. Mỗi yêu cầu được lưu trong mục "Yêu cầu báo giá" của trang quản trị và gửi email tới địa chỉ nhận báo giá. Form có kiểm tra cơ bản (mã nonce, ô ẩn chống bot, kiểm tra loại và dung lượng tệp tải lên).

## 4. Ghi chú

Tên công ty, thông tin liên hệ, sản phẩm và giá là dữ liệu mẫu mang tính tham khảo cho mục đích demo.
