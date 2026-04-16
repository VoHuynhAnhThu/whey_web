# FITWHEY - Pure PHP MVC Skeleton

## Cấu trúc

- assets/: CSS, JS, images
- config/: cấu hình app và database
- controllers/: controller classes
- core/: Router, Database, View, base Controller/Model
- models/: model classes
- views/: layouts + public/admin/error views
- routes/web.php: định nghĩa routes
- index.php: front controller

## Chạy local với XAMPP

1. Bật Apache + MySQL.
2. Đặt project ở `htdocs/whey_web`.
3. Truy cập `http://localhost/whey_web/`.

## Cấu hình DB

Sửa thông tin tại `config/database.php`.

Neu gap loi `Unknown database 'whey_web'`:

1. Dam bao MySQL trong XAMPP dang chay.
2. Ung dung da bat `auto_create_database` trong `config/database.php` va se tu tao DB `whey_web` khi truy cap.
3. Neu ban muon tao bang + du lieu mau, chay lan luot:
   - `database/init.sql`
   - `database/seed.sql`

Tai khoan demo trong `seed.sql`:

- admin@fitwhey.local / 12345678
- member@fitwhey.local / 12345678

## Auth va Profile

Da co san cac route:

- GET `/register`, POST `/register`
- GET `/login`, POST `/login`
- POST `/logout`
- GET `/profile`, POST `/profile`
- GET `/admin` (chi role `admin`)

Can tao bang `Users` va `Profiles` theo schema ban da thiet ke truoc do.
