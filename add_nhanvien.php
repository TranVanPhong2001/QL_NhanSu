<?php

// Thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_employee'])) {
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    $sql = "INSERT INTO Nhanvien (Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES ('$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>



