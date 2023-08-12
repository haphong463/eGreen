<!DOCTYPE html>
<html>
<head>
    <title>Shop Chat</title>
</head>
<body>
    <h1>Welcome to our shop's chat</h1>
    <div id="chat-container">
        <div id="chat-log"></div>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Type your message...">
            <button type="submit">Send</button>
        </form>
    </div>
    <script>
        const chatForm = document.getElementById('chat-form');
        const chatLog = document.getElementById('chat-log');
        const userInput = document.getElementById('user-input');

        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const userMessage = userInput.value;
            appendMessage('user', userMessage);

            const response = await fetch('api.php', {
                method: 'POST',
                body: JSON.stringify({ userMessage }),
            });

            const data = await response.json();
            appendMessageWithTyping('AI', data.message);

            userInput.value = '';
        });

        function appendMessage(sender, message) {
            chatLog.innerHTML += `<p><strong>${sender}:</strong> ${message}</p>`;
        }

        function appendMessageWithTyping(sender, message) {
            const messageContainer = document.createElement('p');
            messageContainer.innerHTML = `<strong>${sender}:</strong> <span id="response"></span>`;
            chatLog.appendChild(messageContainer);

            const responseContainer = messageContainer.querySelector('#response');
            let charIndex = 0;

            const typingInterval = setInterval(() => {
                responseContainer.textContent += message[charIndex];
                charIndex++;

                if (charIndex === message.length) {
                    clearInterval(typingInterval);
                }
            }, 50);
        }
    </script>
</body>
</html>