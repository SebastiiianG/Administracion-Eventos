// Obtener la ruta actual
const currentPath = window.location.pathname.split('/').pop();

// Seleccionar todos los enlaces de navegación
const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
    // Obtener el nombre del archivo del enlace
    const linkPath = link.getAttribute('href');

    // Comparar y añadir la clase 'active' si coincide
    if (linkPath === currentPath) {
        link.classList.add('active');
    }
});

