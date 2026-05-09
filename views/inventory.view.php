<?php require __DIR__ . '/partials/header.view.php'; ?>
<?php require __DIR__ . '/partials/nav.view.php'; ?>

    <section class="inventory py-5">
        <div class="container">

            <h1 class="text-center text-warning mb-5">Your Inventory</h1>

            <?php if (!empty($items)): ?>

                <div class="row g-4">

                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4">

                            <div class="card bg-dark text-white shadow">

                                <div class="card-body text-center">

                                    <h3><?= htmlspecialchars($item['item_name']) ?></h3>

                                    <p>Type: <?= htmlspecialchars($item['item_type'] ?? 'Unknown') ?></p>

                                    <p>Price: <?= htmlspecialchars($item['item_price'] ?? 0) ?> Galleons</p>

                                    <p>
                                        Quantity:
                                        <span class="text-warning">
                                        <?= htmlspecialchars($item['quantity'] ?? 0) ?>
                                    </span>
                                    </p>

                                    <!-- REMOVE ONE ITEM -->
                                    <form method="POST" action="/inventory/remove">
                                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">

                                        <button type="submit" class="btn btn-danger btn-sm mt-2">
                                            Remove One
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="text-center text-light">
                    <h3>No items in your inventory yet 🧙‍♂️</h3>
                    <p>Go to the shop and buy something magical!</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

<?php require __DIR__ . '/partials/footer.view.php'; ?>