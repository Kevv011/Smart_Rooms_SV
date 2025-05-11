document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    <div id="alojamientos-data" data-alojamientos='<?= json_encode($alojamientos) ?>'></div> // Datos de PHP a JS


    console.log("Script cargado!"); // Debe aparecer en consola al recargar
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM cargado"); // Verifica esto
    const searchToggle = document.getElementById('search-toggle');
    console.log(searchToggle); // Debe mostrar el elemento
});
    // Alternar visibilidad de la barra
    searchToggle.addEventListener('click', function() {
        searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
        if (searchBox.style.display === 'block') {
            searchInput.focus();
        }
    });

    // Filtrado en tiempo real
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        searchResults.innerHTML = '';
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        const filtered = alojamientos.filter(alojamiento => 
            !alojamiento.eliminado && (
                alojamiento.nombre.toLowerCase().includes(query) ||
                alojamiento.departamento.toLowerCase().includes(query)
            )
        );

        if (filtered.length > 0) {
            filtered.forEach(item => {
                const div = document.createElement('div');
                div.className = 'result-item';
                div.innerHTML = `
                    <strong>${item.nombre}</strong>
                    <small class="d-block text-muted">${item.departamento}</small>
                    <small class="text-success">$${item.precio} USD/noche</small>
                `;
                div.addEventListener('click', () => {
                    window.location.href = `/${_SESSION.rootFolder}/Alojamiento/getAlojamiento?id=${item.id}`;
                });
                searchResults.appendChild(div);
            });
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div class="result-item text-muted">No se encontraron resultados</div>';
            searchResults.style.display = 'block';
        }
    });

    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target)) 
        {
            searchResults.style.display = 'none';
        }
    });
});