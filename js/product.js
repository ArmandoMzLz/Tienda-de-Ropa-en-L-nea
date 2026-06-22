const incBoton = document.getElementById('btnArriba');
const decBoton = document.getElementById('btnAbajo');
const cantidad = document.getElementById('cantidad');

const inc10Boton = document.getElementById('inc10');
const inc100Boton = document.getElementById('inc100');
const inc1000Boton = document.getElementById('inc1000');

incBoton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual < 99) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual + 1;
    }
});

decBoton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual > 1) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual - 1;
    }
});

cantidad.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

cantidad.addEventListener('blur', function () {
    if(this.value === '')
        this.value = 1;

    const valorActual = parseInt(this.value, 10);
    const minValor = 1;
    const maxValor = 99;

    if(valorActual < minValor)
        this.value = minValor;
    if(valorActual > maxValor)
        this.value = maxValor;
});

document.querySelector('.anadir-carrito-button').addEventListener('click', async () => {
    const seleccionada = document.querySelector('input[name="talla"]:checked');

    if (!seleccionada) {
        alert('Por favor selecciona una talla');
        return;
    }

    const varianteID = seleccionada.dataset.varianteId;
    const cantidad = parseInt(document.getElementById('cantidad').value, 10);
    const csrfToken = document.getElementById('csrfToken').value;

    try {
        const respuesta = await fetch('/controller/carritoAjaxController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ accion: 'agregar', varianteID, cantidad, csrf_token: csrfToken })
        });

        const datos = await respuesta.json();

        if (!datos.exito) {
            alert(datos.error);
            return;
        }

        alert('Producto agregado al carrito');
    } catch (error) {
        alert('Ocurrió un error al agregar el producto al carrito.');
    }
});