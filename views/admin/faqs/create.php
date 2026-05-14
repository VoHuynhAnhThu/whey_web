<link rel="stylesheet" href="/whey_web/assets/css/about.css">

<div class="admin-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 1.5rem; color: #333;">Thêm câu hỏi thường gặp (FAQ)</h1>
        <a href="/whey_web/admin/faqs" class="btn-cancel" style="background-color: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 6px; font-weight: 600;">
            🔙 Quay lại
        </a>
    </div>

    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="/whey_web/admin/faqs/store" method="POST">
            
            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block; font-weight: 600; margin-bottom: 8px;">Tiêu đề câu hỏi <span style="color: red;">*</span></label>
                <input type="text" id="title" name="title" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
                       placeholder="VD: Shop có hỗ trợ ship COD toàn quốc không?">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="body" style="display: block; font-weight: 600; margin-bottom: 8px;">Chi tiết câu hỏi (Không bắt buộc)</label>
                <textarea id="body" name="body" rows="3" 
                          style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
                          placeholder="Nhập thêm chi tiết mô tả câu hỏi nếu cần..."></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="answer_body" style="display: block; font-weight: 600; margin-bottom: 8px; color: #27ae60;">Câu trả lời (Admin)</label>
                <textarea id="answer_body" name="answer_body" rows="5" 
                          style="width: 100%; padding: 10px; border: 1px solid #2ecc71; border-radius: 4px; box-sizing: border-box;"
                          placeholder="Nhập câu trả lời để hiển thị trên trang FAQ..."></textarea>
                <small style="color: #666; display: block; margin-top: 5px;">* Nếu điền câu trả lời, hệ thống sẽ tự động chuyển trạng thái thành "Đã trả lời".</small>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background-color: #2ECC71; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 1rem;">
                    💾 Lưu câu hỏi
                </button>
            </div>
            
        </form>
    </div>
</div>