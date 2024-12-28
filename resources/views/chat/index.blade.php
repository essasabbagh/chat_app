<!-- resources/views/chat/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container px-4 py-8 mx-auto">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg">
                <!-- Chat Messages -->
                <div id="chat-messages" class="p-4 space-y-4 overflow-y-auto h-96">
                    <!-- Messages will be appended here -->
                </div>

                <!-- Input Form -->
                <div class="p-4 border-t">
                    <form id="chat-form" class="flex gap-2">
                        <input type="text" id="message-input"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Ask me anything about the project...">
                        <button type="submit"
                            class="px-6 py-2 text-white transition bg-blue-500 rounded-lg hover:bg-blue-600">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message-input');
            const messages = document.getElementById('chat-messages');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const message = input.value;
                if (!message.trim()) return;

                // Add user message to chat
                appendMessage('user', message);
                input.value = '';

                // Update the fetch error handling in your Blade template
                try {
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            message
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        appendMessage('bot', data.message);
                    } else {
                        console.error('Error details:', data);
                        appendMessage('bot', `Error: ${data.message}`);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    appendMessage('bot', 'Network error: ' + error.message);
                }
            });

            function appendMessage(sender, content) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `p-4 rounded-lg ${
                    sender === 'user'
                        ? 'bg-blue-100 ml-12'
                        : 'bg-gray-100 mr-12'
                }`;
                messageDiv.textContent = content;
                messages.appendChild(messageDiv);
                messages.scrollTop = messages.scrollHeight;
            }
        });
    </script>
</body>

</html>
