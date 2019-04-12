<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

// 2. Nếu người dùng có bấm nút Đăng nhập thì thực thi câu lệnh UPDATE
if(isset($_POST['btnDangNhap'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Câu lệnh SELECT
    $sql = "SELECT * FROM `khachhang` WHERE kh_tendangnhap = '$username' AND kh_matkhau = '$password';";

    // Thực thi SELECT
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0) {
        echo 'Đăng nhập thành công!';
        $_SESSION['username'] = $username;
        $_SESSION['trangthai'] = 1; // 1: Đăng nhập thành công; 0: Thất bại
    }
    else {
        echo 'Đăng nhập thất bại!';
    }

    // Đóng kết nối
    mysqli_close($conn);

    // // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    // header('location:index.php');
}

if(isset($_SESSION['username'])) {
    echo "<h1>Xin chào mừng ". $_SESSION['username'] ."</h1>";
    echo session_save_path();
    //header('location:dashboard.php');
}
else {
    // Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/pages/login.html.twig`
    // với dữ liệu truyền vào file giao diện được đặt tên là `login`
    echo $twig->render('backend/pages/login.html.twig' );
}