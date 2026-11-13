# Website quản lý và trao đổi đồ dùng học tập cũ

Cài đặt (XAMPP)

1. Cài XAMPP, khởi động Apache và MySQL trong XAMPP Control Panel.
2. Copy toàn bộ thư mục `trao-doi-do-dung` vào `C:\xampp\htdocs\`.
3. Mở `http://localhost/phpmyadmin`, vào tab **Import**, chọn file `trao_doi_hoc_tap.sql` trong thư mục này → bấm **Go**.
   (Hoặc mở tab SQL và dán nội dung file `trao_doi_hoc_tap.sql` vào rồi chạy.)
4. Mở trình duyệt: `http://localhost/trao-doi-do-dung-v2/`

Tài khoản demo có sẵn

| Vai trò | Email | Mật khẩu |
|---|---|---|
| Admin | admin@example.com | admin123 |
| Sinh viên | sinhvien@example.com | sv123456 |


+ Phân quyền

- Chưa đăng nhập: chỉ xem được trang chủ và chi tiết tin, không thấy thông tin liên hệ/thanh toán.
- Sinh viên: đăng tin, sửa/xóa tin của mình, liên hệ và xác nhận thanh toán với tin người khác.
- Admin: thêm menu "Quản trị" — duyệt/từ chối tin đăng, quản lý môn học, xem lịch sử giao dịch.
  Truy cập trực tiếp URL trong thư mục `admin/` khi chưa đăng nhập admin sẽ tự chuyển hướng về trang đăng nhập.

+ Chức năng thanh toán

Đây là **thanh toán giả lập** (không kết nối cổng thanh toán thật): người mua xác nhận số tiền và hình thức
(tiền mặt/chuyển khoản) → hệ thống lưu vào bảng `GiaoDich` và sinh biên nhận điện tử. Giao dịch tiền thật
diễn ra ngoài hệ thống, do hai bên tự thỏa thuận.


## Bổ sung: ảnh thật khi đăng tin

- Tạo thư mục `uploads/tin/` (đã có trong bản v2).
- Mở phpMyAdmin, chọn database `trao_doi_hoc_tap` và chạy file `database_anh.sql`.
- Form Đăng tin hỗ trợ tối đa 5 ảnh, JPG/JPEG/PNG/WEBP, mỗi ảnh tối đa 5MB.
- Trên điện thoại, nút chọn ảnh có `capture="environment"` để ưu tiên camera sau.
- Ảnh được lưu trong `uploads/tin/`, MySQL chỉ lưu đường dẫn và thứ tự ảnh.
