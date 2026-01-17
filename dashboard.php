<?php
require_once 'config/session.php';
require_once 'classes/User.php';
require_once 'classes/Car.php';

requireLogin();

$user = new User();
$car = new Car();

$userData = $user->getUserById($_SESSION['user_id']);
$products = $car->getAllCars();
$totalProducts = count($products);
$availableProducts = count(array_filter($products, function($p) { return $p['status'] === 'Available'; }));
$soldProducts = count(array_filter($products, function($p) { return $p['status'] === 'Sold'; }));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Óptica Visión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="dashboard.php" class="logo">👓 Óptica Visión</a>
                <nav>
                    <ul class="nav-menu">
                        <li><a href="dashboard.php">Panel</a></li>
                        <li><a href="cars.php">Productos</a></li>
                        <li><a href="add-car.php">Agregar</a></li>
                        <li><a href="profile.php">Perfil</a></li>
                    </ul>
                </nav>
                <div class="user-info">
                    <span>Bienvenido, <?php echo htmlspecialchars($userData['full_name']); ?></span>
                    <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Panel de Control</h1>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $totalProducts; ?></div>
                        <div class="stat-label">Total Productos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $availableProducts; ?></div>
                        <div class="stat-label">Disponibles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $soldProducts; ?></div>
                        <div class="stat-label">Vendidos</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Información del Usuario</h2>
                </div>
                <div class="grid grid-2">
                    <div>
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                    </div>
                    <div>
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($userData['full_name']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($userData['phone'] ?? 'No proporcionado'); ?></p>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <a href="profile.php" class="btn btn-primary">Editar Perfil</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Productos Recientes</h2>
                </div>
                <div class="grid grid-3">
                    <?php 
                    $recentProducts = array_slice($products, 0, 6);
                    foreach ($recentProducts as $product): 
                    ?>
                        <div class="car-card" 
                             data-brand="<?php echo htmlspecialchars($product['brand']); ?>"
                             data-fuel-type="<?php echo htmlspecialchars($product['fuel_type']); ?>"
                             data-transmission="<?php echo htmlspecialchars($product['transmission']); ?>">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['brand'] . ' ' . $product['model']); ?>" 
                                 class="car-image">
                            <div class="car-info">
                                <h3 class="car-title"><?php echo htmlspecialchars($product['brand'] . ' ' . $product['model']); ?></h3>
                                <div class="car-price">$<?php echo number_format($product['price'], 2); ?></div>
                                <div class="car-details">
                                    <span>Tipo: <?php echo $product['fuel_type']; ?></span>
                                    <span>Para: <?php echo $product['transmission']; ?></span>
                                    <span>Color: <?php echo $product['color']; ?></span>
                                    <span>Estado: <?php echo $product['status']; ?></span>
                                </div>
                                <div class="car-actions">
                                    <a href="edit-car.php?id=<?php echo $product['id']; ?>" class="btn btn-warning">Editar</a>
                                    <a href="javascript:void(0)" 
                                       onclick="confirmDelete('<?php echo htmlspecialchars($product['brand'] . ' ' . $product['model']); ?>', 'delete-car.php?id=<?php echo $product['id']; ?>')" 
                                       class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="cars.php" class="btn btn-primary">Ver Todos los Productos</a>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
