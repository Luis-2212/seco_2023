<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: ../index.php");
}
include "../conexion.php";

// Procesar formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['productName'];
    $description = $_POST['productDescription'];
    $price = $_POST['productPrice'];
    $stock = $_POST['productStock'];
    $image = $_POST['productImage'];

    $stmt = $conexion->prepare("INSERT INTO productos (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $description, $price, $stock, $image);
    $stmt->execute();
    $stmt->close();
}

// Obtener productos
$productos = $conexion->query("SELECT * FROM productos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Pedidos</title>
    <link rel="stylesheet" href="productos.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../imagenes/seco_icon.png" alt="Logo del sistema de pedidos, icono de caja con checklist en azul" />
            <h1>Sistema de Control de Ventas</h1>
            <h5><a href="../inicio/inicio.php">inicio</a></h5>
            <h5><a href="../clientes/clientes.php">Clientes</a></h5>
            <h5><a href="../productos/productos.php">Productos</a></h5>
            <h5><a href="../reportes/reportes.php">Reportes</a></h5>
            <h5><a href="../pedidos/pedidos.php">Pedidos</a></h5>
            <h5><a href="../index.php">Salir</a></h5>
        </div>
    </header>
    <div class="container">
        <aside class="sidebar">
            <h2>Gestión de Productos</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="productName">Nombre del Producto</label>
                    <input type="text" name="productName" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Descripción</label>
                    <textarea name="productDescription" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="productPrice">Precio ($)</label>
                    <input type="number" name="productPrice" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="productStock">Stock</label>
                    <input type="number" name="productStock" min="0" required>
                </div>
                <div class="form-group">
                    <label for="productImage">Imagen URL (opcional)</label>
                    <input type="text" name="productImage" placeholder="Dejar vacío para imagen predeterminada">
                </div>
                <button type="submit">Agregar Producto</button>
            </form>
        </aside>
        <main class="main-content">
            <div class="tab-container">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="catalog">Catálogo</button>
                    <button class="tab-btn" data-tab="inventory">Inventario</button>
                </div>
                <div class="tab-content active" id="catalog">
                    <h2>Catálogo de Productos</h2>
                    <p>Seleccione un producto para realizar acciones</p>
                    <div class="products-grid">
                        <?php while($row = $productos->fetch_assoc()): ?>
                            <div class="product-card">
                                <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" class="product-img">
                                <div class="product-info">
                                    <h3 class="product-title"><?= $row['name'] ?></h3>
                                    <p><?= $row['description'] ?></p>
                                    <p class="product-price">$<?= number_format($row['price'], 2) ?></p>
                                    <p class="product-stock">Stock: <?= $row['stock'] ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-content" id="inventory">
                    <h2>Inventario Actual</h2>
                    <p>Resumen completo del stock disponible</p>
                    <div class="table-responsive">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $productos->data_seek(0);
                                while($row = $productos->fetch_assoc()):
                                    $stockStatus = $row["stock"] == 0 ? 'Agotado' : ($row["stock"] < 5 ? 'Bajo stock' : 'Disponible');
                                ?>
                                    <tr>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['description'] ?></td>
                                        <td>$<?= number_format($row['price'], 2) ?></td>
                                        <td><?= $row['stock'] ?></td>
                                        <td><?= $stockStatus ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>