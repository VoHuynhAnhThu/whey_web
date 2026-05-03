<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới - FITWHEY</title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
    <link rel="stylesheet" href="/whey_web/assets/css/admin-users.css">
</head>
<body>

<main class="container mt-4">
    <div class="card form-card">
        <h2 class="form-title">Thêm người dùng mới</h2>
        
        <form action="/whey_web/admin/users/add" method="POST" class="form-grid">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       placeholder="example@gmail.com" autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Nhập mật khẩu" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select name="role" id="role">
                    <option value="member">Thành viên (Member)</option>
                    <option value="admin">Quản trị viên (Admin)</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu người dùng</button>
                <a href="/whey_web/admin/users" class="btn-cancel">Hủy bỏ</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>