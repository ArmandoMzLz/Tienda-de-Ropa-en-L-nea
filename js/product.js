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