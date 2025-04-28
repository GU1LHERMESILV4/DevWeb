// Ação do botão para iniciar o chat
document.getElementById('start-chat').addEventListener('click', function() {
  document.getElementById('chat').style.display = 'block';
  document.getElementById('start-chat').style.display = 'none';
});

// Adiciona evento para fechar o chat e mostrar o botão novamente
const closeBtn = document.getElementById('close-chat');
if (closeBtn) {
  closeBtn.addEventListener('click', function() {
    document.getElementById('chat').style.display = 'none';
    document.getElementById('start-chat').style.display = 'inline-block';
  });
}

// Envio da mensagem pelo usuário
document.getElementById('send-message').addEventListener('click', async function() {
  let userInput = document.getElementById('user-input').value.trim();

  if (userInput) {
    addMessage(userInput, 'user');
    document.getElementById('user-input').value = '';  // Limpar o campo de entrada

    // Chamada à API do ChatGPT via servidor Node.js
    try {
      const response = await fetch('http://localhost:3000/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message: userInput }),
      });

      const data = await response.json();

      if (data.response) {
        addMessage(data.response, 'bot');
      } else {
        addMessage('Desculpe, não consegui entender isso.', 'bot');
      }
    } catch (error) {
      console.error('Erro ao buscar resposta do bot:', error);
      addMessage('Ocorreu um erro. Tente novamente mais tarde.', 'bot');
    }
  }
});

// Função para adicionar mensagens no chat
function addMessage(message, sender) {
  let messageDiv = document.createElement('div');
  messageDiv.classList.add('message');
  messageDiv.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
  messageDiv.innerHTML = message;
  document.getElementById('chat-box').appendChild(messageDiv);

  // Scroll para a última mensagem
  document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
}
