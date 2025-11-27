/**
 * Hotel Admin - Main JavaScript File
 * Consolidated JavaScript for all application features
 */

// ============================================
// CLIENT SEARCH - For Clients Index Page
// ============================================
function initClientSearch() {
    const searchInput = document.getElementById('searchClients');
    if (!searchInput) return;

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.trim();
        const resultsDiv = document.getElementById('searchResults');

        if (term.length < 2) {
            resultsDiv.style.display = 'none';
            return;
        }

        fetch(`/clients/search?term=${encodeURIComponent(term)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    resultsDiv.innerHTML = data.map(client => `
                        <a href="/clients/show/${client.id}" class="list-group-item list-group-item-action">
                            <i class="bi bi-person"></i> ${client.full_name}
                            <small class="text-muted ms-2">${client.dni}</small>
                        </a>
                    `).join('');
                    resultsDiv.style.display = 'block';
                } else {
                    resultsDiv.innerHTML = '<div class="list-group-item text-muted">No hay resultados</div>';
                    resultsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error en búsqueda de clientes:', error);
            });
    });

    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#searchClients') && !e.target.closest('#searchResults')) {
            const resultsDiv = document.getElementById('searchResults');
            if (resultsDiv) resultsDiv.style.display = 'none';
        }
    });
}

// ============================================
// CLIENT SELECTOR - For Check-in Form
// ============================================
function initClientSelector() {
    const clientSelect = document.getElementById("client_id");
    if (!clientSelect) return;

    clientSelect.addEventListener("change", function() {
        const selectedText = this.options[this.selectedIndex].text;
        console.log("Cliente seleccionado:", selectedText);
        
        // Aquí puedes agregar más lógica si necesitas hacer algo cuando se selecciona un cliente
    });
}

// ============================================
// FORM VALIDATIONS
// ============================================
function initFormValidations() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

// ============================================
// AUTO-HIDE ALERTS
// ============================================
function initAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // 5 segundos
    });
}

// ============================================
// CONFIRM DELETE ACTIONS
// ============================================
function initDeleteConfirmations() {
    const deleteLinks = document.querySelectorAll('a[href*="/delete/"]');
    
    deleteLinks.forEach(link => {
        if (!link.hasAttribute('onclick')) {
            link.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    e.preventDefault();
                }
            });
        }
    });
}

// ============================================
// INITIALIZE ALL FEATURES
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initClientSearch();
    initClientSelector();
    initFormValidations();
    initAutoHideAlerts();
    initDeleteConfirmations();
    
    console.log('Hotel Admin - JavaScript initialized');
});
