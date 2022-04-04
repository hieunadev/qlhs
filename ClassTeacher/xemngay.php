<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Bảng điều khiển</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Xem ngày đã điểm danh</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Trang chủ</a></li>
              <li class="breadcrumb-item active" aria-current="page">Xem ngày đã điểm danh</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark">Xem ngày đã điểm danh</h6>
                  <?php echo $trangThaiMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Nhập ngày<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" name="dateTaken" id="exampleInputFirstName" placeholder="Class Arm Name">
                      </div>
                      <!-- <div class="col-xl-6">
                        <label class="form-control-label">Class Arm Name<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="tenLop" value="<?php echo $row['tenLop']; ?>" id="exampleInputFirstName" placeholder="Class Arm Name">
                        </div> -->
                    </div>
                    <button type="submit" name="view" class="btn btn-dark">Xác nhận</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-dark">Hiển thị</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>STT</th>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Ngày sinh</th>
                            <th>Số báo danh</th>
                            <th>Khối</th>
                            <th>Lớp</th>
                            <th>Năm học</th>
                            <th>Học kì</th>
                            <th>Tình trạng</th>
                            <th>Ngày</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php

                          if (isset($_POST['view'])) {

                            $dateTaken =  $_POST['dateTaken'];

                            $query = "SELECT diemdanh.Id,diemdanh.trangThai,diemdanh.ngayTao,khoi.khoiLop,
                      lop.tenLop, namhoc.namHoc ,namhoc.maHocKy,hocky.tenHK,
                      hocsinh.firstName,hocsinh.lastName,hocsinh.ngaysinh,hocsinh.admissionNumber
                      FROM diemdanh
                      INNER JOIN khoi ON khoi.Id = diemdanh.maKhoi
                      INNER JOIN lop ON lop.Id = diemdanh.maLop
                      INNER JOIN namhoc ON namhoc.Id = diemdanh.maNamHoc
                      INNER JOIN hocky ON hocky.Id = namhoc.maHocKy
                      INNER JOIN hocsinh ON hocsinh.admissionNumber = diemdanh.admissionNo
                      where diemdanh.ngayTao = '$dateTaken' and diemdanh.maKhoi = '$_SESSION[maKhoi]' and diemdanh.maLop = '$_SESSION[maLop]'";
                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            $sn = 0;
                            $trangThai = "";
                            if ($num > 0) {
                              while ($rows = $rs->fetch_assoc()) {
                                if ($rows['trangThai'] == '1') {
                                  $trangThai = "Present";
                                  $colour = "#00FF00";
                                } else {
                                  $trangThai = "Absent";
                                  $colour = "#FF0000";
                                }
                                $sn = $sn + 1;
                                echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['firstName'] . "</td>
                                <td>" . $rows['lastName'] . "</td>
                                <td>" . $rows['ngaysinh'] . "</td>
                                <td>" . $rows['admissionNumber'] . "</td>
                                <td>" . $rows['khoiLop'] . "</td>
                                <td>" . $rows['tenLop'] . "</td>
                                <td>" . $rows['namHoc'] . "</td>
                                <td>" . $rows['tenHK'] . "</td>
                                <td style='background-color:" . $colour . "'>" . $trangThai . "</td>
                                <td>" . $rows['ngayTao'] . "</td>
                              </tr>";
                              }
                            } else {
                              echo
                              "<div class='alert alert-danger' role='alert'>
                            Không tìm thấy!
                            </div>";
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->


          </div>
          <!---Container Fluid-->
        </div>
        <!-- Footer -->
        <?php include "Includes/footer.php"; ?>
        <!-- Footer -->
      </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
      $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
      });
    </script>
</body>

</html>