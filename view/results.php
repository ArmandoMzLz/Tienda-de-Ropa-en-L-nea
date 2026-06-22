<?php include 'header.php'; ?>
<link rel="stylesheet" href="/css/search.css">

<main class="search-container">
    <header class="search-header">
        <h1>Resultados para: 
            <span>
                "<?php echo htmlspecialchars($_GET['busqueda'] ?? ''); ?>"
            </span>
        </h1>
        <p>12 productos encontrados</p> 
    </header>

    <div class="search-layout">
        <aside class="filters-sidebar">
            <form action="results.php" method="GET">
                
                <div class="filter-group">
                    <h3>Ordenar por</h3>
                    <select name="ordenar" id="ordenar">
                        <option value="populares">Más populares</option>
                        <option value="precio_asc">Precio: Menor a Mayor</option>
                        <option value="precio_desc">Precio: Mayor a Menor</option>
                    </select>
                </div>

                <div class="filter-group">
                    <h3>Categoría</h3>
                    <label><input type="radio" name="categoria" value="hombre"> Hombre</label>
                    <label><input type="radio" name="categoria" value="mujer"> Mujer</label>
                </div>

                <div class="filter-group">
                    <h3>Marca</h3>
                    <label><input type="checkbox" name="marca[]" value="nike"> Nike</label>
                    <label><input type="checkbox" name="marca[]" value="adidas"> Adidas</label>
                    <label><input type="checkbox" name="marca[]" value="puma"> Puma</label>
                </div>

                <button type="submit" class="btn-filtrar">Aplicar Filtros</button>
            </form>
        </aside>

        <section class="products-grid">
            
            <article class="product-card">
                <div class="product-image">
                    <img src="/images/jersey_mexico.jpg" alt="Jersey México Local">
                </div>
                <div class="product-info">
                    <span class="brand">Adidas</span>
                    <h2>Jersey México Local 2026</h2>
                    <p class="price">$1,799.00</p>
                    <a href="product.php?id=8" class="btn-ver">Ver Detalles</a>
                </div>
            </article>

            <article class="product-card">
                <div class="product-image">
                    <img src="/images/tenis_nike.jpg" alt="Nike Air Max">
                </div>
                <div class="product-info">
                    <span class="brand">Nike</span>
                    <h2>Nike Air Max 270</h2>
                    <p class="price">$2,899.00</p>
                    <a href="product.php?id=15" class="btn-ver">Ver Detalles</a>
                </div>
            </article>

        </section>
    </div>
</main>

<?php include 'footer.php'; ?>