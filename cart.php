<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">🛒 Keranjang Saya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <?php if (empty($cartItems)): ?>
          <p class="text-center text-muted">
            Keranjang masih kosong
          </p>
        <?php else: ?>

        <table class="table align-middle">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $total = 0; ?>
          <?php foreach ($cartItems as $item): ?>
            <?php 
              $subtotal = $item['harga'] * $item['qty'];
              $total += $subtotal;
            ?>
            <tr>
              <td>
                <img src="assets/img/<?= $item['gambar'] ?>" width="60" class="me-2 rounded">
                <?= $item['nama_produk'] ?>
              </td>
              <td>Rp. <?= number_format($item['harga']) ?></td>
              <td><?= $item['qty'] ?></td>  
              <td>Rp. <?= number_format($subtotal) ?></td>
              
              <td class="text-center">
                <form action="update_cart.php" method="POST" class="d-inline">
                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                <input type="hidden" name="aksi" value="kurang">
                <button class="btn btn-outline-secondary btn-sm">−</button>
                </form>

                <span class="mx-2"><?= $item['qty'] ?></span>

                <form action="update_cart.php" method="POST" class="d-inline">
                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                <input type="hidden" name="aksi" value="tambah">
                <button class="btn btn-outline-secondary btn-sm">+</button>
                </form>
              </td>

              <td class="text-center">
                  <form action="hapus_cart.php" method="POST">
                  <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                  <button type="submit" class="btn btn-danger btn-sm">
                      🗑 Hapus
                  </button>
                  </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>

        <div class="text-end fw-bold">
          Total: Rp. <?= number_format($total) ?>
        </div>

        <?php endif; ?>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>
