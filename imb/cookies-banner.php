<div id="cookie-banner" class="cookie-banner">
    <p>Usamos cookies para mejorar su experiencia en nuestro sitio web. <a href="cookies.html">Más información</a></p>
    <button onclick="aceptarCookies()">Aceptar</button>
    <button onclick="rechazarCookies()">Rechazar</button>
</div>

<script>
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + "; path=/" + expires;
    }

    function aceptarCookies() {
        setCookie("cookies_aceptadas", "true", 30);
        document.getElementById('cookie-banner').style.display = 'none';
    }

    function rechazarCookies() {
        setCookie("cookies_aceptadas", "false", 30);
        document.getElementById('cookie-banner').style.display = 'none';
    }

    window.onload = function() {
        if (document.cookie.indexOf("cookies_aceptadas=true") !== -1 || document.cookie.indexOf("cookies_aceptadas=false") !== -1) {
            document.getElementById('cookie-banner').style.display = 'none';
        }
    };
    <script src="cookies.js"></script>
</script>

<style>
    .cookie-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 14px;
    }
    .cookie-banner a{
        color:#47a0ff ;
    }
    .cookie-banner button {
        background: #47a0ff;
        color: white;
        border: none;
        padding: 8px 15px;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
    }
    .cookie-banner button:last-child {
        background: #47a0ff;
    }
    .cookie-banner button:hover{
        background-color:#93c7ff ;

    }
</style>