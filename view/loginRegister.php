<?php 
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/registerController.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/loginRegister.css">
        <title>Kicks & Jerseys | Sign in | Sign up</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <div class="container" id="container">
                <div class="form-container sign-up">
                    <form method="POST" action="/controller/authController.php" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <h1>Crear cuenta</h1><br>
                        <input type="text" name="nombre" placeholder="Nombre" required>
                        <input type="text" name="apellido" placeholder="Apellido(s)" required>
                        <input type="email" name="email" placeholder="Correo Electrónico" required>
                        <input type="password" name="contrasena" placeholder="Contraseña" required>
                        <input type="password" name="confirmar" placeholder="Confirmar Contraseña" required>
                        <br>
                        <button type="submit" name="action" value="register">Crear cuenta</button>
                    </form>
                </div>
                <div class="form-container sign-in">
                    <form method="POST" action="/controller/authController.php" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <h1>Iniciar Sesión</h1><br>
                        <input type="email" name="email" placeholder="Correo Electrónico" required>
                        <input type="password" name="contrasena" placeholder="Contraseña" required>
                        <br>
                        <button type="submit" name="action" value="login">Iniciar Sesión</button><br>
                    </form>
                </div>
                <div class="toggle-container">
                    <div class="toggle">
                        <div class="toggle-panel toggle-left">
                            <h1>¿Ya tiene una cuenta?</h1><br>
                            <p>Si ya tiene una cuenta, puede iniciar sesión aquí</p><br>
                            <button class="hidden" id="login">Iniciar Sesión</button>
                        </div>
                        <div class="toggle-panel toggle-right">
                            <h1>¿No tiene una cuenta?</h1><br>
                            <p>Si aún no tiene una cuenta, puede registrarse aquí</p><br>
                            <button class="hidden" id="register">Registrarme</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($_SESSION['auth_error']) || !empty($_SESSION['auth_success'])): ?>
                <div class="mensaje-overlay" id="mensajeOverlay">
                    <div class="mensaje-contenedor">
                        <button class="cerrar" onclick="cerrarMensaje()">&times;</button>
                        <?php if (!empty($_SESSION['auth_error'])): ?>
                            <p class="mensaje-error"><?= htmlspecialchars($_SESSION['auth_error'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['auth_error']); ?>
                        <?php endif; ?>
                         <?php if (!empty($_SESSION['auth_success'])): ?>
                            <p class="mensaje-exito"><?= htmlspecialchars($_SESSION['auth_success'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['auth_success']); ?>
                         <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/loginRegister.js"></script>
    </body>
</html>