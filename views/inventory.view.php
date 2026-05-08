<?php require __DIR__ . '/partials/header.view.php'; ?>
<?php require __DIR__ . '/partials/nav.view.php'; ?>


    <section class="inventory">
        <div class="container py-5">

            <h1 class="text-center text-warning mb-5">Your Inventory</h1>

            <div class="row g-4">

                <?php foreach ($inventory as $item): ?>
                    <div class="col-md-4">

                        <div class="card inventory-card">

                            <div class="card-body text-center">

                                <h3><?= $item['name'] ?></h3>
                                <p><?= $item['category'] ?></p>
                                <p>Qty: <?= $item['quantity'] ?></p>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>

<?php require __DIR__ . '/partials/footer.view.php'; ?>