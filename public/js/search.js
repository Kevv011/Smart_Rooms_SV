document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const cardsContainer = document.querySelector('section.my-4 #cards-presentation');
    const cards = cardsContainer.querySelectorAll('.col-12.col-sm-6.col-md-4.col-lg-3');
    console.log("Tarjetas REALES encontradas:", cards.length);
    
    // Muestra el contenido de las primeras 2 tarjetas para verificar
    if (cards.length > 0) {
        console.log("Texto tarjeta 1:", cards[0].textContent.trim());
        console.log("Texto tarjeta 2:", cards[1].textContent.trim());
    }

    // Función para filtrar
    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let hasVisibleCards = false;
        
        cards.forEach(card => {
            // Busca en TODO el texto de la tarjeta, para facilitar match.
            const cardText = card.textContent.toLowerCase();
            
            if (cardText.includes(searchTerm)) {
                card.style.display = '';
                hasVisibleCards = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mensaje "no resultados"
        const existingMessage = cardsContainer.querySelector('.no-results-message');
        if (!hasVisibleCards) {
            if (!existingMessage) {
                const message = document.createElement('div');
                message.className = 'no-results-message alert alert-warning text-center mt-3';
                message.innerHTML = '<strong>No se encontraron alojamientos para "' + searchTerm + '"</strong>';
                cardsContainer.appendChild(message);
            }
        } else if (existingMessage) {
            existingMessage.remove();
        }
    }

    // Eventos
    searchInput.addEventListener('input', filterCards);
    document.querySelector('.form-buscar').addEventListener('submit', function(e) {
        e.preventDefault();
        filterCards();
    });
});