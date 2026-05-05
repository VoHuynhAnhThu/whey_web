<div class="container mt-5">
    <h2>Liên hệ với chúng tôi</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success">Lời nhắn của bạn đã được gửi đi thành công!</div>
    <?php endif; ?>

    <form action="/whey_web/contact" method="POST" class="mt-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Họ và tên</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="subject" class="form-control">
        </div>
        <div class="mb-3">
            <label>Lời nhắn</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi lời nhắn</button>
    </form>
</div>