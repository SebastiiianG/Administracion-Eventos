document.addEventListener('mousemove', (event) => {
    const layers = document.querySelectorAll('.layer');
    const x = (event.clientX / window.innerWidth) * 2 - 1; // Normaliza el valor de X
    const y = (event.clientY / window.innerHeight) * 2 - 1; // Normaliza el valor de Y
  
    layers.forEach((layer) => {
      const depth = layer.getAttribute('data-depth'); // Obtiene la profundidad
      const movementX = x * 50 * depth; // Ajusta el movimiento en X
      const movementY = y * 50 * depth; // Ajusta el movimiento en Y
      layer.style.transform = `translate(${movementX}px, ${movementY}px)`;
    });
  });
  