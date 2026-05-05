<?php 
// 1. Nhúng phần đầu (CSS, Sidebar, Menu)
include __DIR__ . '/../admin/header.php'; 

// 2. Hiển thị nội dung của từng trang (Dashboard, Settings, Contacts)
echo $content; 

// 3. Nhúng phần chân (JS, Footer)
include __DIR__ . '/../admin/footer.php'; 
?>