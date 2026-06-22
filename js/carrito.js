async function actualizarCantidadCarrito(varianteID, nuevaCantidad) {
    const csrfToken = document.querySelector('input[name="csrf_token"]').value;
    await fetch('/controller/carritoAjaxController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ accion: 'actualizar', varianteID, cantidad: nuevaCantidad, csrf_token: csrfToken })
    });
    location.reload();
}

document.querySelectorAll('.tarjeta-carrito').forEach(tarjeta => {
    const varianteID = tarjeta.dataset.varianteId;
    const inputCantidad = tarjeta.querySelector('.input-cantidad-carrito');

    tarjeta.querySelector('.sumar-cantidad').addEventListener('click', () => {
        const stockMax = parseInt(inputCantidad.dataset.stockMax, 10);
        const actual = parseInt(inputCantidad.value, 10);
        if (actual < stockMax) actualizarCantidadCarrito(varianteID, actual + 1);
    });

    tarjeta.querySelector('.restar-cantidad').addEventListener('click', () => {
        const actual = parseInt(inputCantidad.value, 10);
        actualizarCantidadCarrito(varianteID, actual - 1);
    });

    tarjeta.querySelector('.eliminar-del-carrito').addEventListener('click', async () => {
        const csrfToken = document.querySelector('input[name="csrf_token"]').value;
        await fetch('/controller/carritoAjaxController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ accion: 'eliminar', varianteID, csrf_token: csrfToken })
        });
        location.reload();
    });
});

function cerrarMensaje() {
    const overlay = document.getElementById("mensajeOverlay");
    if (overlay) {
        overlay.remove();
    }
}