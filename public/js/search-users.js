document.addEventListener('DOMContentLoaded', () => {
    const filasUser = document.querySelectorAll('.reserva-user-row');
    const noResults = document.getElementById('no-match-user');

    const filtrosUser = {
        id: document.getElementById('filtro-id-user'),
        nombre: document.getElementById('filtro-nombre-user'),
        fechaReservacion: document.getElementById('filtro-fecha-reservacion-user'),
    };

    const aplicarFiltroUsuario = () => {
        let resultsUser = false;

        filasUser.forEach(fila => {
            const coincide =
                (filtrosUser.id.value === '' || fila.dataset.id.includes(filtrosUser.id.value)) &&
                (filtrosUser.nombre.value === '' || fila.dataset.nombre.includes(filtrosUser.nombre.value.toLowerCase())) &&
                (filtrosUser.fechaReservacion.value === '' || fila.dataset.fechaReservacion === filtrosUser.fechaReservacion.value);

            if (coincide) {
                fila.style.display = '';
                resultsUser = true;
            }
            else {
                fila.style.display = 'none';
            }
        });
        noResults.style.display = resultsUser ? 'none' : 'block';
    };
    Object.values(filtrosUser).forEach(input => {
        input.addEventListener('input', aplicarFiltroUsuario);
    });
});