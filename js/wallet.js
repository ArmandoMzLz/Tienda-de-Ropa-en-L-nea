const incBoton = document.getElementById('btnArriba');
const decBoton = document.getElementById('btnAbajo');
const cantidad = document.getElementById('cantidad');

const inc10Boton = document.getElementById('inc10');
const inc100Boton = document.getElementById('inc100');
const inc1000Boton = document.getElementById('inc1000');

const minValor = 1;
const maxValor = 10000;

incBoton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual < maxValor) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual + 1;
    }
});

decBoton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual > minValor) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual - 1;
    }
});

inc10Boton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual < (maxValor - 10)) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual + 10;
    } else {
        cantidad.value = valorActual + (maxValor - valorActual);
    }
});

inc100Boton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual < (maxValor - 100)) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual + 100;
    } else {
        cantidad.value = valorActual + (maxValor - valorActual);
    }
});

inc1000Boton.addEventListener("click", () => {
    let valorActual = parseInt(cantidad.value, 10);

    if(valorActual < (maxValor - 1000)) {
        valorActual = isNaN(valorActual)? 0 : valorActual;
        cantidad.value = valorActual + 1000;
    } else {
        cantidad.value = valorActual + (maxValor - valorActual);
    }
});

cantidad.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

cantidad.addEventListener('blur', function () {
    if(this.value === '')
        this.value = 1;

    const valorActual = parseInt(this.value, 10);

    if(valorActual < minValor)
        this.value = minValor;
    if(valorActual > maxValor)
        this.value = maxValor;
});