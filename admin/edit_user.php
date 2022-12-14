<?php

include "inclaude\header.php";

$servername = "localhost";
$username = "masdaffa";
$password = "olehmastegar";
$database = "afterguilty";

$connection = new mysqli($servername, $username, $password, $database);

$id_users        = "";
$nama_lengkap    = "";
$alamat          = "";
$level           = "";

$errorMessage   = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (!isset($_GET["id_users"])) {
    header("location: user.php");
    exit;
  }

  $id_users = $_GET["id_users"];

  $sql = "SELECT * FROM users JOIN users_login WHERE users.id_users=$id_users AND users_login.id_users=$id_users";
  $result = $connection->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: user.php");
    exit;
  }

  $nama_lengkap = $row["nama_lengkap"];
  $alamat = $row["alamat"];
  $role = $row["role"];
} else {
  $id_users = $_POST["id_users"];
  $nama_lengkap = $_POST["nama_lengkap"];
  $alamat = $_POST["alamat"];
  $role = $_POST["role"];

  do {
    if (empty($id_users) || empty($nama_lengkap) || empty($alamat) || empty($role)) {
      $errorMessage = "Tolong Diisi Semua";
      break;
    }
    $sql = "UPDATE users JOIN users_login SET users.nama_lengkap = '$nama_lengkap', users.alamat = '$alamat', .users_login.role = '$role'  WHERE users.id_users = $id_users AND users_login.id_users=$id_users";
    $result = $connection->query($sql);

    if (!$result) {
      $errorMessage = "Invalid query: " . $connection->error;
      break;
    }

    $successMessage = "Telah Diperbarui";
    header("location: user.php");
    exit;
  } while (false);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css\style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poiret+One&family=Roboto&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css\bootstrap.min.css">
  <title>Admin Base</title>
</head>

<body>
  <div class="menu no-gutters">
    <div class="col-md-2 bg-dark pr-3 pt-4" style="z-index: 99;position: fixed;padding-bottom: 20%;padding-right: 19%; font-size: 1vw;">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="index.php"><i class="ri-dashboard-2-fill mr-2"></i> Dashboard</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="barang.php"><i class="ri-file-list-2-fill mr-2"></i> Barang</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="pembelian.php"><i class="ri-money-dollar-circle-fill"></i> Pembelian</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="laporan.php"><i class="ri-booklet-fill"></i> Laporan</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="user.php"><i class="ri-user-fill"></i> User</a>
          <hr class="bg-secondary">
        </li>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="foto_profile\blank-profile-picture-973460_1280.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Selamat Datang <br><?php echo $_SESSION['email'] ?></strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['id_users'] ?>">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="..\inclaude\logout.php">Sign out</a></li>
          </ul>
        </div>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-3" style="margin-left: 18%;">
      <h3><i class="ri-user-fill mr-2"></i>EDIT</h3>
      <hr>

      <?php
      if (!empty($errorMessage)) {
        echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
           <strong>$errorMessage</strong>
           <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>
        ";
      }
      ?>

      <form method="post">
        <input type="hidden" name="id_users" value="<?php echo $id_users; ?>">
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nama Lengkap</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $nama_lengkap; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="alamat" value="<?php echo $alamat; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Level</label>
          <div class="col-sm-6">
            <select name="role" id="role" class="form-control" required>
              <option value="">Pilih</option>
              <?php $role = $afterguilty['role']; ?>
              <option value="admin" <?= $role == 'admin' ? 'selected' : null ?>>Admin</option>
              <option value="kustomer" <?= $role == 'kustomer' ? 'selected' : null ?>>Kustomer</option>
            </select>
          </div>
        </div>

        <?php
        if (!empty($successMessage)) {
          echo "
            <div class='row mb-3'>
              <div class='offset-sm-3 col-sm-6'>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>$successMessage</strong>
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
              </div>
           </div>
            ";
        }
        ?>

        <div class="row mb-3">
          <div class="offset-sm-3 col-sm-3 d-grid">
            <button type="submit" class="btn btn-primary" name="proses">Simpan</button>
          </div>
          <div class="offset-sm col-sm-3 d-grid">
            <a class="btn btn-outline-primary" href="user.php" role="button">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js\admin_user.js"></script>
</body>

</html>