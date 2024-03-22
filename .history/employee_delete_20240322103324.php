<?php
require_once("config/db.class.php");

// Kiểm tra xem có tham số id được truyền qua không
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Gọi phương thức xóa nhân viên với mã nhân viên đã được truyền
    $result = Employee::deleteEmployee($id);
    
    if($result) {
        // Nếu xóa thành công, chuyển hướng hoặc hiển thị thông báo thành công
        echo "Nhân viên đã được xóa thành công!";
    } else {
        // Nếu xóa không thành công, hiển thị thông báo lỗi
        echo "Lỗi: Không thể xóa nhân viên.";
    }
} else {
    // Nếu không có id được truyền qua, chuyển hướng hoặc hiển thị thông báo lỗi
    echo "Lỗi: Không có mã nhân viên được cung cấp.";
}
?>
