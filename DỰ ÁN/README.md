# Foodly MVC

Ứng dụng PHP MVC chạy trên XAMPP mô phỏng website đặt đồ ăn online đầy đủ chức năng:

- Đăng ký, đăng nhập, đăng xuất, quên mật khẩu (ghi log liên kết reset)
- Quản lý món ăn, danh mục (admin)
- Giỏ hàng, thanh toán, lịch sử đơn hàng (user)
- Phân quyền admin/user theo session

## Yêu cầu

- PHP 8.1+, Composer, MySQL (XAMPP)
- Môi trường `mod_rewrite` hoặc chạy bằng `php -S` kèm `public/index.php`

## Cài đặt

```bash
composer install
cp env.example .env # trên Windows copy bằng explorer
```

Chỉnh `.env` với thông tin MySQL. Import `database/schema.sql` vào MySQL để tạo bảng và dữ liệu mẫu.

## Chạy ứng dụng

Đặt project vào `htdocs/foodly` (XAMPP) và truy cập `http://localhost/foodly/public`. Nếu dùng PHP server:

```bash
composer serve
```

## Tài khoản mẫu

- Admin: `admin@foodly.local` / `password`

## Cấu trúc chính

- `public/` – entry point
- `src/Core` – Router, View, Session, Request
- `src/Controllers` – xử lý request người dùng
- `src/Services` – nghiệp vụ (auth, cart, order, password reset)
- `src/Repositories` – truy vấn PDO tới MySQL
- `src/Views` – template Bootstrap
- `database/schema.sql` – cấu trúc CSDL & seed dữ liệu
- `storage/logs/reset-links.log` – log liên kết đặt lại mật khẩu

