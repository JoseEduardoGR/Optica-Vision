<?php
require_once 'config/session.php';
require_once 'classes/Car.php';

// Si está logueado, redirigir al dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$car = new Car();
$featuredProducts = array_slice($car->getAllCars(), 0, 8);
$availableProducts = array_filter($car->getAllCars(), function($p) { return $p['status'] === 'Available'; });
$totalAvailable = count($availableProducts);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Óptica Visión - Tu Vista es Nuestra Prioridad</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Estilos específicos para la página de inicio */
        .hero-section {
            background: linear-gradient(135deg, #6a4c93 0%, #9c89b8 50%, #f4a261 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="90" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .features-section {
            padding: 4rem 0;
            background: #f8f9fa;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #6a4c93;
            margin-bottom: 1rem;
        }

        .products-section {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #6a4c93;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: #6c757d;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .cta-section {
            background: linear-gradient(135deg, #2a9d8f, #264653);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #f4a261;
            margin-bottom: 1rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #34495e;
            opacity: 0.8;
        }

        .stats-banner {
            background: white;
            padding: 2rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #6a4c93;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .hero-buttons .btn {
                width: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">👓 Óptica Visión</h1>
                <p class="hero-subtitle">Tu vista es nuestra prioridad. Encuentra los mejores lentes y monturas con la más alta calidad.</p>
                <div class="hero-buttons">
                    <a href="login.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">Iniciar Sesión</a>
                    <a href="register.php" class="btn btn-success" style="font-size: 1.1rem; padding: 1rem 2rem;">Registrarse</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <section class="stats-banner">
        <div class="container">
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number"><?php echo $totalAvailable; ?>+</div>
                    <div class="stat-label">Productos Disponibles</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Años de Experiencia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Clientes Satisfechos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Marcas Reconocidas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">¿Por Qué Elegir Óptica Visión?</h2>
            <p class="section-subtitle">Ofrecemos los mejores servicios y productos para el cuidado de tu vista</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3 class="feature-title">Exámenes Profesionales</h3>
                    <p>Realizamos exámenes de vista completos con equipos de última tecnología para garantizar un diagnóstico preciso.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">👓</div>
                    <h3 class="feature-title">Amplio Catálogo</h3>
                    <p>Contamos con una gran variedad de lentes, monturas y accesorios de las mejores marcas del mercado.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Servicio Rápido</h3>
                    <p>Entrega rápida de tus lentes graduados. La mayoría de pedidos listos en 24-48 horas.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">💎</div>
                    <h3 class="feature-title">Calidad Premium</h3>
                    <p>Solo trabajamos con materiales de la más alta calidad y ofrecemos garantía en todos nuestros productos.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3 class="feature-title">Precios Justos</h3>
                    <p>Ofrecemos los mejores precios del mercado sin comprometer la calidad de nuestros productos y servicios.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title">Atención Personalizada</h3>
                    <p>Nuestro equipo de especialistas te brindará asesoría personalizada para encontrar la mejor opción para ti.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Productos Destacados</h2>
            <p class="section-subtitle">Descubre nuestra selección de productos más populares</p>
            
            <div class="grid grid-3">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="car-card optical-effect">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['brand'] . ' ' . $product['model']); ?>" 
                             class="car-image">
                        <div class="car-info">
                            <h3 class="car-title"><?php echo htmlspecialchars($product['brand'] . ' ' . $product['model']); ?></h3>
                            <div class="car-price">$<?php echo number_format($product['price'], 2); ?></div>
                            <div class="car-details">
                                <span><strong>Tipo:</strong> <?php echo $product['fuel_type']; ?></span>
                                <span><strong>Para:</strong> <?php echo $product['transmission']; ?></span>
                                <span><strong>Color:</strong> <?php echo $product['color']; ?></span>
                                <span><strong>Estado:</strong> 
                                    <span style="color: <?php echo $product['status'] === 'Available' ? '#2a9d8f' : '#e76f51'; ?>">
                                        <?php echo $product['status'] === 'Available' ? 'Disponible' : $product['status']; ?>
                                    </span>
                                </span>
                            </div>
                            <?php if (!empty($product['description'])): ?>
                                <p style="margin-top: 1rem; color: #6c757d; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <p style="margin-bottom: 1rem; color: #6c757d;">¿Quieres ver todos nuestros productos?</p>
                <a href="login.php" class="btn btn-primary" style="font-size: 1.1rem;">Inicia Sesión para Ver Más</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">¿Listo para Cuidar tu Vista?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
                Únete a miles de clientes satisfechos que confían en Óptica Visión
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="register.php" class="btn btn-warning" style="font-size: 1.1rem; padding: 1rem 2rem;">Crear Cuenta Gratis</a>
                <a href="login.php" class="btn" style="background: rgba(255,255,255,0.2); color: white; font-size: 1.1rem; padding: 1rem 2rem;">Ya Tengo Cuenta</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>👓 Óptica Visión</h3>
                    <p>Tu vista es nuestra prioridad. Ofrecemos productos y servicios de la más alta calidad para el cuidado de tus ojos.</p>
                    <p style="margin-top: 1rem;"><strong>Horarios:</strong><br>
                    Lunes a Viernes: 9:00 AM - 7:00 PM<br>
                    Sábados: 9:00 AM - 5:00 PM</p>
                </div>
                
                <div class="footer-section">
                    <h3>Servicios</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">• Exámenes de Vista</li>
                        <li style="margin-bottom: 0.5rem;">• Lentes Graduados</li>
                        <li style="margin-bottom: 0.5rem;">• Lentes de Sol</li>
                        <li style="margin-bottom: 0.5rem;">• Lentes de Contacto</li>
                        <li style="margin-bottom: 0.5rem;">• Reparaciones</li>
                        <li style="margin-bottom: 0.5rem;">• Ajustes Gratuitos</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Marcas</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">• Ray-Ban</li>
                        <li style="margin-bottom: 0.5rem;">• Oakley</li>
                        <li style="margin-bottom: 0.5rem;">• Gucci</li>
                        <li style="margin-bottom: 0.5rem;">• Persol</li>
                        <li style="margin-bottom: 0.5rem;">• Tom Ford</li>
                        <li style="margin-bottom: 0.5rem;">• Y muchas más...</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p><strong>📍 Dirección:</strong><br>
                    Av. Principal #123<br>
                    Centro, Ciudad</p>
                    
                    <p style="margin-top: 1rem;"><strong>📞 Teléfono:</strong><br>
                    +52 (555) 123-4567</p>
                    
                    <p style="margin-top: 1rem;"><strong>✉️ Email:</strong><br>
                    info@opticavision.com</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Óptica Visión. Todos los derechos reservados. | Desarrollado con ❤️ para el cuidado de tu vista.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
    <script>
        // Animación adicional para la página de inicio
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de aparición gradual para las tarjetas
            const cards = document.querySelectorAll('.feature-card, .car-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Efecto de conteo para las estadísticas
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const finalNumber = parseInt(stat.textContent);
                let currentNumber = 0;
                const increment = finalNumber / 50;
                
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        stat.textContent = finalNumber + (stat.textContent.includes('+') ? '+' : '');
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentNumber) + (stat.textContent.includes('+') ? '+' : '');
                    }
                }, 30);
            });
        });
    </script>
</body>
</html>
