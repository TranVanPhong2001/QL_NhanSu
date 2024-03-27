
<ul class="menu">
    
     <li>   
    <a href="add_nhanvien.php"> Thêm sản phẩm</a>
    </li>
</ul>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";
session_start();
// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM Nhanvien";
$result = $conn->query($sql);

if(isset($_GET['logout'])) {
    // Destroy session
    session_unset();
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}
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

// Xác định số trang và trang hiện tại
$rows_per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của bản ghi trên trang hiện tại
$start_from = ($current_page - 1) * $rows_per_page;

// Lấy tổng số nhân viên
$sql_total = "SELECT COUNT(*) AS total FROM Nhanvien";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_rows = $row_total['total'];

// Tính toán số trang
$total_pages = ceil($total_rows / $rows_per_page);

// Truy vấn dữ liệu nhân viên cho trang hiện tại
$sql = "SELECT * FROM Nhanvien LIMIT $start_from, $rows_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output table header
    echo "<table>";
    echo "<tr>
              <th>Mã Nhân Viên</th>
              <th>Tên Nhân Viên</th>
              <th>Giới Tính</th>
              <th>Nơi Sinh</th>
              <th>Tên Phòng</th>
              <th>Lương</th>
          </tr>";
  
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["Ma_NV"] . "</td>";
      echo "<td>" . $row["Ten_NV"] . "</td>";
      echo "<td>";
      if($row["Phai"] == "NAM") {
        echo "<img src='data:image/png;base64,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' alt='Man' width='50' height='50'>";
      } else {
        echo "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAN8AAADjCAMAAAAynzHIAAAAjVBMVEX/////Mf//J///gP//FP//LP//d///i///5P//V///IP//Df//I///Gv//2v//7f//hP//+///8f//rf//bf//6v//mP//9v//4P//0///wP//1v//zv//VP//tf//XP//k///pP//yf//vP//Zf//qv//Sf//fP//nf//Yf//Tf//cf//O///of//jv+6r3ePAAAIZ0lEQVR4nO2da3fiIBCGDQUvEFo18VKrxlu91e3//3mrdd3aATQqA0kPzzn7ZY/N8IYAw2SYVCqBQCAQCAQCgUCgXPT6s2Rdqy6yrJFli2ptncz6Pd+NssPLoLuIJJU8JoQdISTm+/+JFt3Bi+/mPUR7/rQTMmaRHhZLsXuat3038z467yMqiUnbf41E0tF7x3djb6U1bgh+Tdt/jVw0xi3fTb6BelPKvOL+SZSyWffd7Jy8bgS5SdwRIjavvpueg+GI3tZ1Z51IR0Pfzb/CcybuVfelUGTPviVcoLd6SN1R4aqwC38i7xl3ECIT30K0vDSkBXUHZKOAbk1y97SiwmjRurCVUmvqDtC0UOt9P7Ix8s4hUd+3qG/meZ7N/b4hjmO+/7ffR+T4OZ37lnWiK651BpeCbdPmZD2dTteTZrplQvJrXS66voUdqV4ceoSLaJW8wk1Q+zVZReKyRlr1ogew4OYWMsnTsXnz0xmn/JIjzhcOdRjIYmPzYrEYXJsGW4OFuHCFzImGCzRMjWOSrfPtzNtrZuzEuIHc/itsTPJkNL7hMuPI5PvEG7S25+DDMPY4u0XdgTEzXeoDpeW5qOnvOrtrZu8a9h6yZr3dOUn0657M7gsXdTL97RKenNE3rTz2QHMSfReKN4utzk1PO2Di5SOxvs5SO19xH1vehs73eNjl0DpDxMMq0dUNFjF9+LpT3VMvnbuiz7pmiIGFKw+0V3YddtppZgJqJ375qnlE2c7KpXMz0Uwu1NY096YRyCeWLp6LuuYZsjiL61Ye4TJ831CfTjGzeP2ZKpA5nEMH6gNk2cnQuEbUxuSVj0jpPm7bSawpA5xFlk0YeVeWPoQFWHUf5Lt1I3pUxwXBgdK4f8S6ES3vimWrc8sJdY7hbjpQGXwEJ85VVZ8TFDuAuTL6OE4svaU8J9JFyHcL+w8t0DyHyxDbIlk641kxOkKzNVJuJb6b/QRHBeLuWvHTyBOarRNw9DHMAN4GdqBENPbFAOpD3Zkpu0yJ7aSl4PFkuBH0DHQgSVHNVVqw+yjG0v7NDM5mEve97kxZ/FDN7V15qA/3fjbB4xn/QTVXqfwBAUPSRDUHwy4CO7OxA2YY3ECMYg1/Uw1DBah3dA5cQgcePdytcEwfFA4/B0EfGMpCHYBL6E8g2joBLLIlnim4+iFPZkfgM4O4AvbBaos6Fk7AMU/xEpug80ldxFzr4KYiuqBwsY3RLJ0DjeK5FGAoIO5szwG7XMRBD7ZjZIVm6ZwVuKt4G06wPMRrNEvnrH8+oIgLxM+BEPFbk1zuYwzjaGiWwPSJvFc5AfdkaDGKFnCVpJu8jTegT2At8G2gz8nypy6AAutA3QswRN0ca+tAs1inBxRDnvRhmf3t+n7789mD84ubIwpw1yLQstHg+uDmPOIrXB/QLAFHAj1YfgTuyjiapR0w5CbxNAG3FS9CCHYq8QTN0jkT4F/j7crAyxXslx3OrX6CO+kmqQ/EzONPNEtwJFAXh/RaMKiFN+qHML7kYgMBsyUl3hly6Ek4SbiBAXpMrwmEspiLCSYFMXPMoB18308RbZ0AzwxqPkMXdKADDw16ZzFmKj0MhThY4SfwlmIGfeAOwkHOKcylxds9HIAZU+grBFwdkGPma/i6HzthCqaDIceUlew6tGDdERiSRM+wA+Yi/viJo0tMlRxQVHOVSg0u8bgG4eyC6FwfUc7OSMyXEGMlHQzd44UZPqgdCLvPwY5MGRGI5XYS2H3Io/1AWzmbE2NNoS3lsCp1UMtPSduPsV4YN6E+pIMIP1FPbiKl8DozBFAOxyGNeuWIKHKu8ImhMgKtnx47oJ4go46q2ynHEjAOIKnHjxylo+y3nOrhQ257Ymurx8eEs/KLC+Xkk/WkDSVTMSLuivlojhfHdkNNqVqnweUBY+hl75E2V8GmWhwhdlomRXe6f2Lt6hPdCX9rV8+Dcu7CpkCdPORzJAofmuoh1M4jVNPII66rFLV01VGkjVZ86AqTEOflFoe6Mh/x6NHoXW+kq3AjPNTl1RaAIewxF/iZaZ8LL5UIM11T2EMlbqbaAkzETxW7llqm4etm311d1lDhlkWeap3CxL5Te+h9XTg1VBF1lKaoQTvHHLpwd/tqNdsZSvT5mFtOzA0CGc1uC+S9ZaYSsMJrGVdDCbvDPLPJf9+HG2NdcF/F6068G2vTMrpL8qyGvWRnLt8rXNVEMWIWGDEu0ysFTluDVF74ToR/eZXK+FJ1YSLFZmpa8p+nG3GxpLtwcwDhCrPLRfUZp3xUS4b174e1Vx8mtdH+/y//IUpZmTvok2ulnhnhklJBdsvlckcEpZJf/TILIYWp8N3eXqih/EPngXw/5dsifVenea3E960IF0dDb2BAbVagJw6LneWkbaguew8yK9KzeSKx1IWkcF9/+Ec7ffjzK4dVIS1i5x0ZmjYBuZG7Yn8iyFyJPJe6m6qe+yExV5O/zP7vCjrwAOPlHTMNocvi992J12r+r8d9dR0X1TJ8fOybXjK64j6fiaOjXDvFgvGSLKj5443/tMWSLpICfs4pH61ht8EPIlWV7CCNN7rDQn3o6B76826qvI5ly7Q7L8wG6HFAnqqDQoJuCfrKTdBXboK+chP0lZugr9wEfeUm6Cs3QV+5CfrKTdBXboK+cvPb9YHSvU4qZ6Pw8lTT8Am+KsS2n7qfPRX/TURdEB1KfF77K6cfMbwPQ9JyPvylIucm6Av6ikzQF/QVmaAv6CsyQV/QV2R++/6hk1Y1rEACE1uudD9L3VR8R+DX7N8N/Pb4S9BXboK+chP0lZugr9wEfeUm6Cs3QV+5CfrKTdBXboK+crPi7Bzu5tPO7piMGueMJr4bFAgEAoFAIBAIBG7mL+Q2cZu90spRAAAAAElFTkSuQmCC' alt='Woman' width='50' height='50'>";
      }
      echo "</td>";
      echo "<td>" . $row["Noi_Sinh"] . "</td>";
      echo "<td>" . $row["Ma_Phong"] . "</td>";
      echo "<td>" . $row["Luong"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
      </style>";
}

        // Hiển thị phân trang
            echo "<div>";
            for ($page=1; $page<=$total_pages; $page++) {
                echo "<a href='?page=$page'>$page</a> ";
            }
            echo "</div>";
$conn->close();
?>
<a href="?logout=true">Logout</a>