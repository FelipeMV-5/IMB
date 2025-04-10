// Abrir y cerrar el menú de chat
document.getElementById('chat-icon').addEventListener('click', function() {
    var chatMenu = document.getElementById('chat-menu');
    chatMenu.classList.toggle('active'); // Alterna la visibilidad del menú
});

document.getElementById('close-chat').addEventListener('click', function() {
    var chatMenu = document.getElementById('chat-menu');
    chatMenu.classList.remove('active'); // Cierra el menú
});

// Enviar mensaje
document.getElementById('send-btn').addEventListener('click', function() {
    var userInput = document.getElementById('user-input').value;
    if (userInput.trim() !== '') {
        // Mostrar mensaje del usuario en el chat
        displayMessage(userInput, 'user');
        document.getElementById('user-input').value = ''; // Limpiar el campo de entrada

        // Respuesta automática del bot
        setTimeout(function() {
            var botResponse = getBotResponse(userInput);
            displayMessage(botResponse, 'bot');
        }, 1000);
    }
});

// Función para mostrar los mensajes en el chat
function displayMessage(message, sender) {
    var messageDiv = document.createElement('div');
    messageDiv.classList.add('chat-message', sender + '-message');
    
    // Agregar el ícono dependiendo del remitente
    var icon = sender === 'bot' ? '<span class="bot-icon"><i class="fa-solid fa-robot"></i></span>' : '';
    messageDiv.innerHTML = icon + message;
    
    document.getElementById('chat-box').appendChild(messageDiv);
    document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight; // Desplazar al final

    // Animación de entrada suave
    messageDiv.classList.add('message-animate');
}

// Función para obtener la respuesta automática del bot
function getBotResponse(userInput) {
    // Lista de palabras clave y respuestas asociadas
    var responses = {
        'cuenta': 'Para recuperar tu cuenta, puedes restablecer tu contraseña desde la página de inicio de sesión haciendo clic en <a href="https://www.tusitio.com/recuperar-cuenta" target="_blank">"Olvidé mi contraseña"</a>.',
        'problema': 'Por favor, explícalo más detalladamente o usa la opción "Reportar" en la configuración de tu cuenta.',
        'contraseña': 'Para cambiar tu contraseña, ve a la configuración de tu cuenta y selecciona "Cambiar contraseña". Si olvidaste tu contraseña, puedes recuperarla desde la página de inicio de sesión haciendo clic en <a href="https://www.tusitio.com/recuperar-cuenta" target="_blank">"Olvidé mi contraseña"</a>.',
        'desactivar': 'Si deseas desactivar tu cuenta, ve a la configuración de privacidad. Ahí podrás elegir la opción de desactivar temporalmente tu cuenta.',
        'inicio sesión': 'Si no puedes iniciar sesión, asegúrate de que estás usando el correo y la contraseña correctos. Si olvidaste tu contraseña, utiliza la opción "Olvidé mi contraseña" haciendo clic en <a href="https://www.tusitio.com/recuperar-cuenta" target="_blank">este enlace</a>.',
        'seguridad': 'Para mejorar la seguridad de tu cuenta, asegúrate de usar una contraseña fuerte y activar la autenticación de dos factores en la configuración.',
        'notificación': 'Puedes gestionar tus notificaciones desde la configuración de tu cuenta. Ahí puedes elegir qué alertas recibir.',
        'perfil': 'Para editar tu perfil, ve a la sección de configuración y selecciona "Editar perfil".',
        'informar': 'Si deseas informar de un problema, puedes usar la opción "Informar de un problema" en la configuración.',
        'privacidad': 'Para gestionar la privacidad de tu cuenta, ve a la sección de configuración y selecciona "Privacidad y seguridad".'
    };

    // Convertir la entrada a minúsculas para manejar mayúsculas y minúsculas
    userInput = userInput.toLowerCase();

    // Comprobar si la entrada contiene alguna de las palabras clave
    for (var key in responses) {
        if (userInput.includes(key)) {
            return responses[key];
        }
    }

    // Si no hay coincidencias, el bot no tiene una respuesta definida
    return 'Lo siento, no entendí exactamente lo que necesitas. ¿Podrías ser más específico? Aquí tienes algunas sugerencias: \n- Cuenta \n- Contraseña \n- Problema \n- Privacidad';
}
