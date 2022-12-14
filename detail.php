<?php
include "inclaude\db.php";
include "inclaude\header.php"


?>
<?php
$id = $_GET["id"];

$ambil = $connection->query("SELECT * FROM barang WHERE id='$id'");
$detail = $ambil->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets\css\home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poiret+One&family=Roboto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="assets\css\bootstrap.min.css">
  <link rel="stylesheet" href="assets\css\animate.css">
  <link rel="stylesheet" href="assets\css\bootstrap-select.min.css">
  <link rel="stylesheet" href="assets\css\main.css">
  <title>After Guilty.Store</title>

  <head>

  <body style="background: #cfcfcf;">
    <section class="kontent">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="hasil_gambar/<?php echo $detail['gambar'] ?>" alt="" class="img-responsive" style="width: 90%;">
          </div>
          <div class="col-md-6">
            <h2><?php echo $detail['nama'] ?></h2>
            <h6 style="color: #565656;">Jumlah Stok : <?php echo $detail['stock'] ?> Pcs</h6> <br>
            <h4 class="text-danger">Rp.<?php echo number_format($detail['harga']) ?></h4> <br>
            <h6>Deskripsi :</h6>
            <p style="color: #565656;"><?php echo $detail['deskripsi'] ?></p>
            <select class="btn btn-outline-dark text-white form-select" style="background: #222222; width: 20%;">
              <option value="M"><?php echo $detail['ukuran'] ?></option>
            </select>
            <form action="" method="post" class="mt-2">
              <div class="form-group">
                <div class="input-group">
                  <input type="number" min="1" class="form-control" name="jumlah">
                  <div class="input-group-btn ml-2">
                    <button class="btn btn-outline-dark text-white mr-30" style="background: #222222;" name="beli">Beli</button>
                  </div>
                </div>
              </div>
            </form>
            <?php
            if (isset($_POST["beli"])) {
              $jumlah = $_POST["jumlah"];
              $_SESSION["keranjang"][$id] = $jumlah;

              echo "<script>alert('Barang sudah ditambahkan')</script>";
              echo "<script>location='keranjang.php';</script>";
            }
            ?>

          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
          <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
              <svg class="bi" width="30" height="24">
                <use xlink:href="#bootstrap"></use>
              </svg>
            </a>
            <span class="mb-3 mb-md-0 text-muted">?? 2022 AfterGuilty Store. All Right Reserved</span>
          </div>

          <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <a href="https://www.instagram.com/afterguilty.store/" style="color: #181818;"><i class="bi bi-instagram" style="margin-right: 10px;"></i></a>
            <a href="" style="color: #181818;"><i class="bi bi-facebook" style="margin-right: 10px;"></i></a>
            <a href="" style="color: #181818;"><i class="bi bi-twitter" style="margin-right: 10px;"></i></a>
          </ul>
        </footer>
      </div>

    </section>
  </body>
</head>