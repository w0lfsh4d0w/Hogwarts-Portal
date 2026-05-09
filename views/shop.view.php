<?php require __DIR__ . '/partials/header.view.php'; ?>
<?php require __DIR__ . '/partials/nav.view.php'; ?>

    <section class="shop py-5">
        <div class="container">

            <h1 class="text-center text-warning mb-5">Diagon Alley Shop</h1>

            <div class="row g-4">

                <?php foreach ($items as $item): ?>
                    <div class="col-md-4">

                        <div class="card bg-dark text-white shadow">

                            <div class="card-body text-center">

                                <h3><?= htmlspecialchars($item['item_name']) ?></h3>

                                <p>Type: <?= htmlspecialchars($item['item_type']) ?></p>

                                <p>Price: <?= htmlspecialchars($item['item_price']) ?> Galleons</p>

                                <!-- BUY FORM -->
                                <form method="POST" action="/shop/buy">

                                    <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">

                                    <button type="submit" class="btn btn-warning w-100 mt-3">
                                        Buy
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>

<?php require __DIR__ . '/partials/footer.view.php'; ?>