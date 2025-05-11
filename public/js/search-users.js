document.addEventListener('DOMContentLoaded', () => {
    const filasUser = document.querySelectorAll('.reserva-user-row');

    const filtrosUser = {
        id: document.getElementById('filtro-id-user'),
        nombre: document.getElementById('filtro-nombre-user'),
        fechaReservacion: document.getElementById('filtro-fecha-reservacion-user'),
    };

    const aplicarFiltroUsuario = () => {
        filasUser.forEach(fila => {
            const coincide =
                (filtrosUser.id.value === '' || fila.dataset.id.includes(filtrosUser.id.value)) &&
                (filtrosUser.nombre.value === '' || fila.dataset.nombre.includes(filtrosUser.nombre.value.toLowerCase())) &&
                (filtrosUser.fechaReservacion.value === '' || fila.dataset.fechaReservacion === filtrosUser.fechaReservacion.value);

            fila.style.display = coincide ? '' : 'none';
        });
    };

    Object.values(filtrosUser).forEach(input => {
        input.addEventListener('input', aplicarFiltroUsuario);
    });
});