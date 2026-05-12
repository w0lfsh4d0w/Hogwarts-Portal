<?php 
    $current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="/">Hogwarts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                
                <a class="nav-link <?= ($current_uri === '/') ? 'active' : '' ?>" aria-current="page" href="/">Home</a>
                
                <a class="nav-link" href="#about">About</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a class="nav-link <?= ($current_uri === '/shop') ? 'active' : '' ?>" href="/shop">Shop</a>
                    
                    <a class="nav-link <?= ($current_uri === '/inventory') ? 'active' : '' ?>" href="/inventory">Inventory</a>
                    
                    <a class="nav-link <?= ($current_uri === '/dashboard') ? 'active' : '' ?>" href="/dashboard">Dashboard</a>
                    
                    <form action="/logout" method="POST" class="d-inline m-0 p-0">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="nav-link logout me-5 border-0 bg-transparent">Logout</button>
                    </form>
                    
                <?php else: ?>
                    <a class="nav-link register me-5 <?= ($current_uri === '/register') ? 'active' : '' ?>" href="/register">Register</a>
                    
                    <a class="nav-link register me-5 <?= ($current_uri === '/login') ? 'active' : '' ?>" href="/login">Login</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>