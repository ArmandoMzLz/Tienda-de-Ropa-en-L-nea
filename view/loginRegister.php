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
                    <form>
                        <h1>Crear cuenta</h1><br>
                        <input type="text" placeholder="Nombre" id="name" required>
                        <input type="text" placeholder="Apellido(s)" id="last-name" required>
                        <input type="email" placeholder="Correo Electrónico" id="email-sign-up" required>
                        <input type="password" placeholder="Contraseña" id="pass-sign-in" required>
                        <input type="password" placeholder="Confirmar Contraseña" id="confirm-pass" required>
                        <br><button>Crear cuenta</button>
                    </form>
                </div>
                <div class="form-container sign-in">
                    <form>
                        <h1>Iniciar Sesión</h1><br>
                        <input type="email" placeholder="Correo Electrónico" id="email-sign-in" required>
                        <input type="password" placeholder="Contraseña" id="pass-sign-in" required>
                        <br><button>Iniciar Sesión</button><br>
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
                            <p>Si aún no tiene una cuenta, puede registrase aquí</p><br>
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