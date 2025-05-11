document.addEventListener('DOMContentLoaded', () => {
    const filasAdmin = document.querySelectorAll('.reserva-admin-row');

    const filtroId = document.getElementById('filtro-id-admin');
    const filtroFechaReservacion = document.getElementById('filtro-fecha-reservacion-admin');
    const filtroNombre = document.getElementById('filter-nombre-admin');
    const filtroEntrada = document.getElementById('filtro-entrada-admin');
    const filtroSalida = document.getElementById('filtro-salida-admin');

    if (filtroId && filtroFechaReservacion && filtroNombre && filtroEntrada && filtroSalida) {
        const aplicarFiltroAdmin = () => {
            const valorId = filtroId.value.trim().toLowerCase();
            const valorFechaReservacion = filtroFechaReservacion.value.trim();
            const valorNombre = filtroNombre.value.trim().toLowerCase();
            const valorEntrada = filtroEntrada.value.trim();
            const valorSalida = filtroSalida.value.trim();

            filasAdmin.forEach(fila => {
                const dataId = fila.dataset.id.toLowerCase();
                const dataFechaReservacion = fila.dataset.fechaReservacion;
                const dataNombre = fila.dataset.nombre.toLowerCase();
                const dataEntrada = fila.dataset.entrada;
                const dataSalida = fila.dataset.salida;

                const coincide =
                    (valorId === '' || dataId.includes(valorId)) &&
                    (valorFechaReservacion === '' || dataFechaReservacion === valorFechaReservacion) &&
                    (valorNombre === '' || dataNombre.includes(valorNombre)) &&
                    (valorEntrada === '' || dataEntrada === valorEntrada) &&
                    (valorSalida === '' || dataSalida === valorSalida);

                fila.style.display = coincide ? '' : 'none';
            });
        };

        filtroId.addEventListener('input', aplicarFiltroAdmin);
        filtroFechaReservacion.addEventListener('input', aplicarFiltroAdmin);
        filtroNombre.addEventListener('input', aplicarFiltroAdmin);
        filtroEntrada.addEventListener('input', aplicarFiltroAdmin);
        filtroSalida.addEventListener('input', aplicarFiltroAdmin);
    }
});