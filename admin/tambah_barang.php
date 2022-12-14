<?php

include "inclaude\header.php";

$servername = "localhost";
$username = "masdaffa";
$password = "olehmastegar";
$database = "afterguilty";

$connection = new mysqli($servername, $username, $password, $database);

$nama       = "";
$deskripsi  = "";
$ukuran     = "";
$harga      = "";
$stock      = "";
$gambar     = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST["nama"];
  $deskripsi = $_POST["deskripsi"];
  $ukuran = $_POST["ukuran"];
  $harga = $_POST["harga"];
  $stock = $_POST["stock"];

  $gambar = $_FILES["gambar"]["name"];
  $sumber = $_FILES["gambar"]["tmp_name"];
  move_uploaded_file($sumber, "../hasil_gambar/" . $gambar);


  $errorMessage = "";
  $successMessage = "";

  do {
    if (empty($nama) || empty($deskripsi) || empty($ukuran) || empty($harga) || empty($stock) || empty($gambar)) {
      $errorMessage = "Tolong Diisi Semua";
      break;
    }

    $sql = "INSERT INTO barang (nama, deskripsi, ukuran, harga, stock, gambar)" .
      "VALUES ('$nama', '$deskripsi', '$ukuran', '$harga', '$stock', '$gambar')";
    $result = $connection->query($sql);

    if (!$result) {
      $errorMessage = "Invalid query: " . $connection->$error;
      break;
    }

    $nama      = "";
    $deskripsi = "";
    $ukuran    = "";
    $harga     = "";
    $stock     = "";
    $gambar    = "";

    $successMessage = "Barang Sudah Ditambahkan";

    header("location: barang.php");
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
      <h3><i class="ri-file-list-2-fill mr-2"></i>TAMBAH BARANG</h3>
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

      <form action="" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nama" value="<?php echo $nama; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Deskripsi</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="deskripsi" value="<?php echo $deskripsi; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Ukuran</label>
          <div class="col-sm-6">
            <select name="ukuran" id="ukuran" class="form-control" required>
              <?php $ukuran = $afterguilty['ukuran']; ?>
              <option value="M" <?= $ukuran == 'M' ? 'selected' : null ?>>M</option>
              <option value="L" <?= $ukuran == 'L' ? 'selected' : null ?>>L</option>
              <option value="XL" <?= $ukuran == 'XL' ? 'selected' : null ?>>XL</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Harga</label>
          <div class="col-sm-6">
            <input type="number" class="form-control" name="harga" value="<?php echo $harga; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Stock</label>
          <div class="col-sm-6">
            <input type="number" class="form-control" name="stock" value="<?php echo $stock; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Gambar</label>
          <div class="col-sm-6">
            <input type="file" class="form-control" name="gambar" value="<img src='hasil_gambar/<?php echo $gambar; ?>'>">
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          <div class="offset-sm col-sm-3 d-grid">
            <a class="btn btn-outline-primary" href="barang.php" role="button">Batal</a>
          </div>
        </div>

      </form>


    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js\admin_user.js"></script>
</body>

</html>