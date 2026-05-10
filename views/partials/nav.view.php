<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="#">Hogwarts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                <a class="nav-link" href="/shop">Shop</a>
                <a class="nav-link" href="/inventory">Inventory</a>
                <a class="nav-link" href="#about">About</a>
                <a class="nav-link" href="#services">Services</a>
                <a class="nav-link" href="#services">Dashboard</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <form action="/logout" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="nav-link logout me-5">Logout</button>
                    </form>
                <?php else: ?>
                    <a class="nav-link register me-5" href="/register">Register</a>
                    <a class="nav-link register me-5" href="/login">Login</a> <?php endif; ?>
            </div>
        </div>
    </div>
</nav>