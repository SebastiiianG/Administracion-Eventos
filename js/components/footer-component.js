class FooterComponent extends HTMLElement{
    constructor(){
        super();
        const shadow = this.attachShadow({mode:'open'});
        
        shadow.innerHTML = `
            <link href="../css/footerStyles.css" rel="stylesheet">
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <footer>
                <div class="footer-container">
                    <div class="footer-links">
                        <a href="#">Preguntas Frecuentes</a>
                        <a href="#">Ayuda</a>
                        <a href="#">Soporte Técnico</a>
                        <a href="#">Blog</a>
                    </div>
                    <div class="footer-legal">
                        <p>&copy; 2024 Gestor de Eventos. Todos los derechos reservados.</p>
                    </div>
                </div>
            </footer>
        `
    }
}
customElements.define('footer-component',FooterComponent);