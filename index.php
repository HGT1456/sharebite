<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sinh viên</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #0056b3; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .form-group { margin-bottom: 15px; }
        input[type="text"], input[type="email"] { width: calc(100% - 20px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Hệ thống Quản lý Sinh viên</h2>

    <?php
    // 1. Kết nối cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "demo_db");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // 2. XỬ LÝ FORM: Khi người dùng bấm nút "Thêm Sinh viên"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ các ô input
        $ho_ten_moi = $_POST["ho_ten"];
        $email_moi = $_POST["email"];

        // Câu lệnh SQL để thêm dữ liệu vào bảng
        $sql_insert = "INSERT INTO sinh_vien (ho_ten, email) VALUES ('$ho_ten_moi', '$email_moi')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "<p style='color: green;'><strong>✔ Đã thêm sinh viên mới thành công!</strong></p>";
        } else {
            echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
        }
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Họ và Tên:</label><br>
            <input type="text" name="ho_ten" required placeholder="Nhập tên sinh viên...">
        </div>
        <div class="form-group">
            <label>Email:</label><br>
            <input type="email" name="email" required placeholder="Nhập email...">
        </div>
        <button type="submit">Thêm Sinh viên</button>
    </form>

    <?php
    $sql_select = "SELECT id, ho_ten, email FROM sinh_vien";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Họ tên</th><th>Email</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"]. "</td>";
            echo "<td>" . $row["ho_ten"]. "</td>";
            echo "<td>" . $row["email"]. "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Chưa có dữ liệu.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>