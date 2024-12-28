<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #chat-box {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }

        #chat-box div {
            margin: 5px 0;
        }

        .user {
            text-align: right;
            color: blue;
        }

        .bot {
            text-align: left;
            color: green;
        }
    </style>
</head>

<body>
    <h1>Chatbot</h1>
    <div id="chat-box"></div>
    <form id="chat-form">
        <input type="text" id="query" placeholder="Ask me anything..." style="width: 80%;" required>
        <button type="submit">Send</button>
    </form>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const queryInput = document.getElementById('query');

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const userMessage = queryInput.value;
            chatBox.innerHTML += `<div class="user"><strong>You:</strong> ${userMessage}</div>`;
            queryInput.value = '';

            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    query: "Your question here"
                })
            });

            const data = await response.json();
            chatBox.innerHTML += `<div class="bot"><strong>Bot:</strong> ${data.reply}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
</body>

</html>
