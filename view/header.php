<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo" style="font-style: italic">Kicks & Jerseys</a>
        <div class="nav-search">
            <form action="results.php" method="GET" class="search-form">
                <input type="text" name="busqueda" placeholder="Buscar tenis, jerseys..." class="search-input" required>
                <button type="submit" class="search-button">
                    <img src="/images/icons/search.svg" alt="Buscar">
                </button>
            </form>
        </div>
        <button class="navbar-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <ul class="navbar-menu">
            <li><a href="account.php"><img src="/images/icons/account.svg"></a></li>
            <li><a href="wallet.php"><img src="/images/icons/wallet.svg"></a></li>
            <li><a href="car.php"><img src="/images/icons/bag.svg"></a></li>
        </ul>
    </div>
    <script src="/js/header.js"></script>
</nav>