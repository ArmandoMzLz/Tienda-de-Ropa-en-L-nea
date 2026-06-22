document.getElementById('numeroTarjeta').addEventListener('input', (e) => {
    let valor = e.target.value.replace(/\D/g, '').slice(0, 19);
    e.target.value = valor.replace(/(.{4})/g, '$1 ').trim();
});

document.getElementById('codigoSeguridad').addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
});

document.getElementById('vencimiento').addEventListener('input', (e) => {
    let valor = e.target.value.replace(/\D/g, '').slice(0, 4);
    if (valor.length > 2) {
        valor = valor.slice(0, 2) + '/' + valor.slice(2);
    }
    e.target.value = valor;
});

const MONTO_MINIMO = 10;
const MONTO_MAXIMO = 50000;
const inputCantidad = document.getElementById('cantidad');

function ajustarMonto(diferencia) {
    const valorActual = parseInt(inputCantidad.value, 10) || 0;
    const nuevoValor = Math.max(MONTO_MINIMO, Math.min(MONTO_MAXIMO, valorActual + diferencia));
    inputCantidad.value = nuevoValor;
}

document.getElementById('btnAbajo').addEventListener('click', () => ajustarMonto(-1));
document.getElementById('btnArriba').addEventListener('click', () => ajustarMonto(1));
document.getElementById('inc10').addEventListener('click', () => ajustarMonto(10));
document.getElementById('inc100').addEventListener('click', () => ajustarMonto(100));
document.getElementById('inc1000').addEventListener('click', () => ajustarMonto(1000));

function cerrarMensaje() {
    const overlay = document.getElementById("mensajeOverlay");
    if (overlay) {
        overlay.remove();
    }
}