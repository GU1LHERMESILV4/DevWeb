// Scripts de interação da landing page (index.html)

document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('user-input');
  const sendBtn = document.getElementById('send-message');
  const chatSection = document.getElementById('chat');
  const closeBtn = document.getElementById('close-chat');
  const openBtn = document.getElementById('start-chat');
  if (input && sendBtn) {
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        sendBtn.click();
      }
    });
  }
  if (closeBtn && chatSection) {
    closeBtn.addEventListener('click', function() {
      chatSection.style.display = 'none';
    });
  }
  if (openBtn && chatSection) {
    openBtn.addEventListener('click', function(e) {
      chatSection.style.display = 'block';
    });
  }

  // Redireciona ao clicar em Status ao Vivo
  var statusBtn = document.getElementById('status-ao-vivo');
  if (statusBtn) {
    statusBtn.style.cursor = 'pointer';
    statusBtn.addEventListener('click', function() {
      window.open('https://draft5.gg/equipe/330-FURIA', '_blank');
    });
  }
});
