document.addEventListener('DOMContentLoaded', () => {
    const filas = document.querySelectorAll('.reserva-admin-row');

    const filtros = {
        id: document.getElementById('filtro-id-admin'),
        nombre: document.getElementById('filtro-nombre-admin'),
        fechaReservacion: document.getElementById('filtro-fecha-reservacion-admin'),
        entrada: document.getElementById('filtro-entrada-admin'),
        salida: document.getElementById('filtro-salida-admin'),
    };

    const aplicarFiltro = () => {
        let resultsAdmin = false;
        
        filas.forEach(fila => {
            const coincide =
                (filtros.id.value === '' || fila.dataset.id.includes(filtros.id.value)) &&
                (filtros.nombre.value === '' || fila.dataset.nombre.includes(filtros.nombre.value.toLowerCase())) &&
                (filtros.fechaReservacion.value === '' || fila.dataset.fechaReservacion === filtros.fechaReservacion.value) &&
                (filtros.entrada.value === '' || fila.dataset.entrada === filtros.entrada.value) &&
                (filtros.salida.value === '' || fila.dataset.salida === filtros.salida.value);

            if (coincide) {
                fila.style.display = '';
                resultsAdmin = true;
            }
            else {
                fila.style.display = 'none';
            }
        });
        document.getElementById('no-match-admin').style.display = resultsAdmin ? 'none' : 'block';
    };
    Object.values(filtros).forEach(input => {
        input.addEventListener('input', aplicarFiltro);
    });
});