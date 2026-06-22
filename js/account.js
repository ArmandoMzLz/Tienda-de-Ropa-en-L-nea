document.getElementById('formCodigoPostal').addEventListener('submit', async (e) => {
    e.preventDefault();

    const codigoPostal = document.getElementById('codigoPostal').value.trim();
    const mensaje = document.getElementById('mensajeCP');
    mensaje.style.display = 'none';

    try {
        const respuesta = await fetch('/controller/accountController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'codigoPostal=' + encodeURIComponent(codigoPostal)
        });

        const datos = await respuesta.json();

        if (!datos.exito) {
            mensaje.textContent = datos.error;
            mensaje.style.display = 'block';
            return;
        }

        document.getElementById('estado').value = datos.estado;
        document.getElementById('municipio').value = datos.municipio;

        const datalist = document.getElementById('listaColonias');
        datalist.innerHTML = '';
        datos.colonias.forEach(colonia => {
            const opcion = document.createElement('option');
            opcion.value = colonia;
            datalist.appendChild(opcion);
        });

        document.getElementById('colonia').value = datos.colonias.length === 1 ? datos.colonias[0] : '';

    } catch (error) {
        mensaje.textContent = 'Ocurrió un error al consultar el código postal.';
        mensaje.style.display = 'block';
    }
});

document.getElementById('numeroTelefono').addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
});

function cerrarMensaje() {
    document.getElementById("mensajeOverlay").style.display = "none";
}