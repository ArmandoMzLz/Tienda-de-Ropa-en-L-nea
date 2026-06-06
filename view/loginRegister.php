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
            <div class="container <?= !empty($errors) ? 'active' : '' ?>" id="container">
                <div class="form-container sign-up">
                    <form method="POST" action="/controller/authController.php" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <h1>Crear cuenta</h1><br>
                        <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>"   required>
                        <input type="text" name="apellido" placeholder="Apellido(s)" value="<?= htmlspecialchars($apellido) ?>" required>
                        <input type="email" name="email" placeholder="Correo Electrónico" value="<?= htmlspecialchars($email) ?>"    required>
                        <input type="password" name="contrasena" placeholder="Contraseña" required>
                        <input type="password" name="confirmar" placeholder="Confirmar Contraseña" required>
                        <?php if (!empty($errors)): ?>
                            <ul class="error-message">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
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
                        <?php if (!empty($errors)): ?>
                            <ul class="error-message">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <br>
                        <button type="submit" name="action" value="login">Iniciar Sesión</button><br>
                        <a href="#">¿Olvidó su contraseña?</a>
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
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/loginRegister.js"></script>
    </body>
</html>