class HeaderComponent extends HTMLElement {
    constructor() {
        super();
        const shadow = this.attachShadow({ mode: 'open' }); /* Crea un DOM shadow para aislar elementos y estilos del resto de la página */

        // Crear el contenido del componente
        shadow.innerHTML = `
            <link href="../css/headerStyles.css" rel="stylesheet">
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <header>
                <h1>
                    Gestor de eventos UAEH
                </h1>
                <p>
                    El <strong>orden</strong> en la gestión, el <strong>amor</strong> en la participación, y el <strong>progreso</strong> en cada experiencia.
                </p>
            </header>
            <nav>
                <a class = "nav-element">
                    Elemento de prueba 
                </a>
            </nav>
        `;
    }
}

// Definir el elemento personalizado
customElements.define('header-component', HeaderComponent);
