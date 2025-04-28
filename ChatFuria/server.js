const express = require('express');
const axios = require('axios');
const dotenv = require('dotenv');
const cors = require('cors');

dotenv.config(); // Carregar variáveis de ambiente

const app = express();
const port = 3000;

app.use(cors());
app.use(express.json());

// Rota para enviar mensagens para o ChatGPT
app.post('/chat', async (req, res) => {
  const { message } = req.body;

  if (!message) {
    return res.status(400).json({ error: 'Mensagem não fornecida' });
  }

  try {
    const response = await axios.post('https://api.openai.com/v1/chat/completions', {
      model: "gpt-3.5-turbo",
      messages: [{ role: 'user', content: message }],
    }, {
      headers: {
        'Authorization': `Bearer ${process.env.OPENAI_API_KEY}`,
        'Content-Type': 'application/json'
      }
    });

    const chatResponse = response.data.choices[0].message.content;
    res.json({ response: chatResponse });

  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Erro ao se comunicar com a OpenAI' });
  }
});

app.listen(port, () => {
  console.log(`Server rodando na porta ${port}`);
});
