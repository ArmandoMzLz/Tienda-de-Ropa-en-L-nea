<?php 
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/registerController.php';

if (empty($_SESSION['usuarioID'])) {
    header('Location: /view/loginRegister.php');
    exit;
}

$perfil = obtenerPerfilUsuario((int) $_SESSION['usuarioID']);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/account.css">
        <title>Kicks & Jerseys | Cuenta</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <?php if (!empty($_SESSION['account_error']) || !empty($_SESSION['account_success'])): ?>
                <div class="mensaje-overlay" id="mensajeOverlay">
                    <div class="mensaje-contenedor">
                        <button class="cerrar" onclick="cerrarMensaje()">&times;</button>
                        <?php if (!empty($_SESSION['account_error'])): ?>
                            <p class="mensaje-error"><?= htmlspecialchars($_SESSION['account_error'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['account_error']); ?>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['account_success'])): ?>
                            <p class="mensaje-exito"><?= htmlspecialchars($_SESSION['account_success'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['account_success']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="datos-usuario">
                <h1>Cuenta</h1>
                <label>
                    Correo Electrónico
                    <input type="text" id="email" value="<?= htmlspecialchars($perfil['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly>
                </label>
                <label>
                    Nombre
                    <input type="text" id="nombreCompleto" value="<?= htmlspecialchars(trim(($perfil['nombre'] ?? '') . ' ' . ($perfil['apellido'] ?? '')), ENT_QUOTES, 'UTF-8') ?>" readonly>
                </label>
                <form method="post" action="/controller/passwordController.php" id="cambiarContrasena">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <input type="password" id="contrasenaActual" name="contrasenaActual" placeholder="Contraseña Actual" required>
                    <input type="password" id="nuevaContrasena" name="nuevaContrasena" placeholder="Nueva Contraseña" required>
                    <input type="password" id="confirmarContrasena" name="confirmarContrasena" placeholder="Confirmar Nueva Contraseña" required>
                    <button type="submit">Cambiar Contraseña</button>
                </form>
            </div>
            <div class="registrar-datos">
                <h1>Registre sus Datos</h1>
                    <?php if (!empty($perfil['direccion'])): ?>
                        <p>Dirección actual: <?= htmlspecialchars($perfil['direccion'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p>Si deseas actualizarla, busca tu código postal nuevamente y completa el formulario.</p>
                    <?php endif; ?>
                <form id="formCodigoPostal" method="post" action="/controller/accountController.php">
                    <input type="text" id="codigoPostal" name="codigoPostal" placeholder="Código postal" maxlength="5" pattern="\d{5}" required>
                    <button type="submit">Buscar</button>
                </form>
                <p id="mensajeCP" class="mensaje-error" style="display:none;"></p>
                <form method="post" action="/controller/direccionController.php" id="formDireccion">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="datos-codigo-postal">
                        <input type="text" id="estado" name="estado" placeholder="Estado" required>
                        <input type="text" id="municipio" name="municipio" placeholder="Municipio" required>
                        <input type="text" id="colonia" name="colonia" placeholder="Colonia" list="listaColonias" required>
                        <datalist id="listaColonias"></datalist>
                    </div>
                    <div class="direccion-input">
                        <input type="text" id="direccionDetalle" name="direccionDetalle" placeholder="Calle y número" required>
                    </div>
                    <div class="numero-input">
                        <input type="text" id="numeroTelefono" name="numeroTelefono"
                               placeholder="Número de Teléfono"
                               value="<?= htmlspecialchars($perfil['numeroTelefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit">Guardar Datos</button>
                    </div>
                </form>
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/account.js"></script>
    </body>
</html>