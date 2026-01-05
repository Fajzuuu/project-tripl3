<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id_produk'])) {
    echo "ID produk tidak ditemukan";
    exit;
}

$id_produk = $_GET['id_produk'];

$query = $koneksi->prepare("SELECT * FROM produk WHERE id_produk=?");
$query->execute([$id_produk]);
$produk = $query->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Product | Tech Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body{
            background:#f5f5f5;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/logo.png" alt="Logo" width="40" class="me-2">
            <span>TECH STORE</span>
        </a>

        <!-- SEARCH -->
        <form class="d-flex mx-auto w-50">
            <input class="form-control me-2" type="search" placeholder="Search product...">
            <button class="btn btn-danger" type="submit">Search</button>
        </form>

        <!-- BUTTON -->
        <?php if (isset($_SESSION['login'])): ?>
<div class="dropdown">
  <button class="btn btn-outline-light"
          data-bs-toggle="dropdown"
          aria-expanded="false">
    <?= substr($_SESSION['username'], 0, 7) ?>
  </button>

  <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width: 220px;">
    
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <li class="mb-2 fw-semibold text-center">
        Selamat datang admin
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="dropdown-item" href="tambah_produk.php">
          ➕ Tambah Barang
        </a>
      </li>

    <?php else: ?>
      <li class="mb-2 fw-semibold text-center">
        Halo <?= $_SESSION['username'] ?>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="dropdown-item" href="#">
          🎟️ Voucher Saya
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="#">
          💰 Saldo
        </a>
      </li>
    <?php endif; ?>

    <li><hr class="dropdown-divider"></li>
    <li>
      <a class="dropdown-item text-danger" href="logout.php">
        🚪 Logout
      </a>
    </li>

  </ul>
</div>
    <?php else: ?>
        <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
        </button>
    <?php endif; ?>
            </button>
            <button class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#cartModal">
                Cart
            </button>
        </div>
    </div>
</nav>

<!-- LOGIN MODAL -->
<?php include "login.php"; ?>

<!-- CART MODAL -->
<?php include "cart.php"; ?>

<div class="container my-5">
  <div class="row">

    <!-- KIRI: GAMBAR -->
    <div class="col-md-5">
      <img src="assets/img/<?= $produk['gambar'] ?>" 
           class="img-fluid rounded">
    </div>

    <!-- KANAN: DETAIL -->
    <div class="col-md-7">

      <h2 class="fw-bold">
        <?= $produk['nama_produk'] ?>
      </h2>

      <?php if (!empty($produk['harga_diskon'])): ?>
    <p class="text-muted text-decoration-line-through">
      Rp. <?= number_format($produk['harga'], 0, ',', '.') ?>
    </p>

    <h3 class="text-danger fw-bold">
      Rp. <?= number_format($produk['harga_diskon'], 0, ',', '.') ?>
    </h3>
    <?php else: ?>
      <h3 class="text-danger fw-bold">
      Rp. <?= number_format($produk['harga'], 0, ',', '.') ?>
      </h3>
    <?php endif; ?>

      <!-- BUTTON ADMIN / USER -->
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

  <a href="edit_barang.php?id_produk=<?= $produk['id_produk'] ?>"
     class="btn btn-warning me-2">
     ✏ Edit Product
  </a>

  <button class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#hapusModal">
  🗑 Hapus
</button>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<div class="modal fade" id="hapusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title text-danger">Hapus Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>
          Yakin ingin menghapus produk:
          <strong><?= $produk['nama_produk'] ?></strong>?
        </p>
        <p class="text-muted">
          Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Batal
        </button>
        <a href="hapus_barang.php?id_produk=<?= $produk['id_produk'] ?>"
           class="btn btn-danger">
          Ya, Hapus
        </a>
      </div>

    </div>
  </div>
</div>
<?php endif; ?>


<?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>

  <form action="add_to_cart.php" method="POST" class="d-inline">
    <input type="hidden" name="id_produk"
           value="<?= $produk['id_produk'] ?>">
    <button type="submit" class="btn btn-danger">
      🛒 Tambah ke Keranjang
    </button>
  </form>

<?php endif; ?>


      <!-- TAB -->
      <ul class="nav nav-tabs mt-4">
        <li class="nav-item">
          <button class="nav-link active"
                  data-bs-toggle="tab"
                  data-bs-target="#desc">
            Deskripsi
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#spec">
            Spesifikasi
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#review">
            Review
          </button>
        </li>
      </ul>

      <div class="tab-content mt-3">

        <div class="tab-pane fade show active" id="desc">
          <p><?= nl2br($produk['deskripsi']) ?></p>
        </div>

        <div class="tab-pane fade" id="spec">
          <p><?= nl2br($produk['spesifikasi']) ?></p>
        </div>

        <div class="tab-pane fade" id="review">
          <p>Belum ada review.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section-box">
    <section id="special-offer" class="product-section">
    <div class="container">
        <h2 class="section-title text-danger"><strong>SPECIAL OFFER</strong></h2>

        <div class="product-grid">

       <?php while ($row = $query->fetch()): ?>
<div class="product-card special-card">
    <div class="product-img-wrapper">
        <img src="assets/img/<?= $row['gambar'] ?>">
    </div>

    <h4><?= $row['nama_produk'] ?></h4>

    <p class="text-muted text-decoration-line-through">
        Rp. <?= number_format($row['harga']) ?>
    </p>

    <p class="text-danger fw-bold">
        Rp. <?= number_format($row['harga_diskon']) ?>
    </p>

    <a href="detail_produk.php?id_produk=<?= $row['id_produk'] ?>" class="btn-red">
  Read more
</a>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
  <div class="admin-action mt-2 d-flex gap-2 justify-content-center" style="z-index: 10;">
    <a href="edit_produk.php?id_produk=<?= $row['id_produk'] ?>"
       class="btn btn-warning btn-sm">
       ✏ Edit
    </a>
    <button type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#hapusModal<?= $row['id_produk'] ?>">
  🗑 Hapus
</button>
  </div>
<?php endif; ?>
</div>
<div class="modal fade"
     id="hapusModal<?= $row['id_produk'] ?>"
     tabindex="-1">

  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title text-danger">Hapus Produk</h5>
        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>
          Yakin ingin menghapus produk:
          <strong><?= $row['nama_produk'] ?></strong>?
        </p>
        <p class="text-muted">
          Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary"
                data-bs-dismiss="modal">
          Batal
        </button>

        <a href="hapus_barang.php?id_produk=<?= $row['id_produk'] ?>"
           class="btn btn-danger">
          Ya, Hapus
        </a>
      </div>

    </div>
  </div>
</div>
<?php endwhile; ?>
        </div>
    </div>
    </section>
</div>
</div>

<!-- FOOTER --> 
<footer class="bg-dark text-light mt-5">
    <div class="container py-4">
        <div class="row"> 
            <div class="col-md-4">
                <h5>Triple Computer</h5>
                <p>Website penjualan perangkat gaming dan komputer.</p>
            </div> 
                <div class="col-md-4"> 
                    <h5>Menu</h5> 
                    <ul class="list-unstyled">
                         <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                          <li><a href="#" class="text-light text-decoration-none">Product</a></li>
                           <li><a href="#" class="text-light text-decoration-none">Category</a></li>
                         </ul>
                </div> 
                <div class="col-md-4">
                    <h5>Contact</h5> 
                    <p>Email: tripl3.store@email.com</p> <p>Phone: 0812-2222-3333</p> 
                </div>
        </div> 
            <hr> 
            <p class="text-center mb-0">&copy; 2025 TRIPL3 COMPUTER | project</p>
    </div> 
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
