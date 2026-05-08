<?php require __DIR__ . '/partials/header.view.php'; ?>
<?php require __DIR__ . '/partials/nav.view.php'; ?>

    <section class="shop">
        <div class="container py-5">

            <h1 class="text-center text-warning mb-5">Diagon Alley Shop</h1>

            <div class="row g-4">

                <?php foreach ($items as $item): ?>
                    <div class="col-md-4">

                        <div class="card shop-card">

                            <div class="card-body text-center">

                                <h3><?= $item['name'] ?></h3>
                                <p><?= $item['category'] ?></p>
                                <p><?= $item['price'] ?> Galleons</p>

                                <form method="POST" action="/shop/buy">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <button class="btn btn-warning w-100">Buy</button>
                                </form>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>

<?php require __DIR__ . '/partials/footer.view.php'; ?>