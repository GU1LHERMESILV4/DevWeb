const questions = [
  {
    q: "Em que ano a FURIA Esports foi fundada?",
    options: ["2016", "2017", "2018", "2019"],
    answer: 1 // b) 2017
  },
  {
    q: "Qual é o país de origem da FURIA?",
    options: ["Estados Unidos", "Canadá", "Portugal", "Brasil"],
    answer: 3 // d) Brasil
  },
  {
    q: "Qual destes jogadores é conhecido por ser o capitão e IGL no CS:GO/CS2 da FURIA?",
    options: ["saffee", "arT", "yuurih", "KSCERATO"],
    answer: 1 // b) arT
  },
  {
    q: "Qual dessas modalidades a FURIA NÃO participou oficialmente até 2025?",
    options: ["Rainbow Six Siege", "League of Legends", "Counter-Strike", "Valorant"],
    answer: 0 // a) Rainbow Six Siege
  },
  {
    q: "Em qual desses torneios a FURIA chegou às semifinais de um Major de CS:GO?",
    options: ["PGL Major Stockholm 2021", "IEM Katowice 2020", "IEM Rio Major 2022", "BLAST Premier Spring Final 2021"],
    answer: 2 // c) IEM Rio Major 2022
  },
  {
    q: "Qual é o apelido de Kaike Cerato, jogador da FURIA?",
    options: ["saffee", "drop", "chelo", "KSCERATO"],
    answer: 3 // d) KSCERATO
  },
  {
    q: "Qual é o nome do projeto educacional da FURIA voltado para formação de novos talentos?",
    options: ["FURIA Academy", "FURIA Next", "FURIA Base", "FURIA Future"],
    answer: 0 // a) FURIA Academy
  },
  {
    q: "Em qual região do CBLOL a FURIA compete em League of Legends?",
    options: ["NA LCS", "LEC", "CBLOL", "LPL"],
    answer: 2 // c) CBLOL
  },
  {
    q: "Qual das frases abaixo representa o espírito da FURIA?",
    options: ["Força e Honra", "Avante com Garra", "Sangue nos olhos, fogo no coração", "Pelo Jogo, Pela Nação"],
    answer: 2 // c) "Sangue nos olhos, fogo no coração"
  },
  {
    q: "Qual destes é um dos fundadores da FURIA?",
    options: ["Alexandre “Gaules” Borba", "André Akkari", "Gabriel “FalleN” Toledo", "Felipe “brTT” Gonçalves"],
    answer: 1 // b) André Akkari
  }
];

let quizOrder = [];
let current = 0;
let score = 0;

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
}

function startQuiz() {
  quizOrder = Array.from({length: questions.length}, (_, i) => i);
  shuffle(quizOrder);
  current = 0;
  score = 0;
  showQuestion();
  document.getElementById('quiz-footer').textContent = `Pergunta 1 de ${questions.length}`;
}

function showQuestion() {
  const qIdx = quizOrder[current];
  const qObj = questions[qIdx];
  let html = `<div class="question">${qObj.q}</div><div class="answers" style="display:flex;flex-direction:column;align-items:center;">`;
  qObj.options.forEach((opt, idx) => {
    html += `<button class="answer-btn" style="margin:4px auto;display:block;" data-idx="${idx}">${String.fromCharCode(97+idx)}) ${opt}</button>`;
  });
  html += '</div>';
  html += `<div style="display:flex;justify-content:center;"><button id="next-question" class="btn-restart" style="display:none;margin-top:14px;">Próxima</button></div>`;
  document.getElementById('quiz-content').innerHTML = html;
  let answered = false;
  document.querySelectorAll('.answer-btn').forEach(btn => {
    btn.onclick = function() {
      if (!answered) {
        checkAnswer(parseInt(btn.getAttribute('data-idx')));
        answered = true;
        // Mostra o botão de próxima pergunta
        const nextBtn = document.getElementById('next-question');
        if (nextBtn) nextBtn.style.display = 'block';
      }
    };
  });
  document.getElementById('quiz-footer').textContent = `Pergunta ${current+1} de ${questions.length}`;
  // Próxima pergunta ao clicar no botão
  document.getElementById('next-question').onclick = function() {
    current++;
    if (current < questions.length) {
      showQuestion();
    } else {
      showResult();
    }
  };
}

function checkAnswer(selected) {
  const qIdx = quizOrder[current];
  const qObj = questions[qIdx];
  const correct = qObj.answer;
  document.querySelectorAll('.answer-btn').forEach((btn, idx) => {
    btn.disabled = true;
    if (idx === correct) {
      btn.classList.add('selected');
      if (selected === correct) {
        btn.style.background = '#4caf50';
        btn.style.color = '#fff';
        btn.style.border = '3px solid #4caf50'; // borda verde
        btn.style.fontWeight = 'bold';
        btn.style.boxShadow = '0 0 16px 4px #4caf50cc';
        btn.innerHTML = `✔️ <b>${btn.innerText}</b> <span style="color:#388e3c;font-weight:bold;">(CORRETA)</span>`;
      } else {
        btn.style.background = '#fff200';
        btn.style.color = '#181818';
        btn.style.border = '3px solid #ff0000';
        btn.style.fontWeight = 'bold';
        btn.style.boxShadow = '0 0 16px 4px #ff0000cc';
        btn.innerHTML = `✔️ <b>${btn.innerText}</b> <span style="color:#ff0000;font-weight:bold;">(CORRETA)</span>`;
      }
    }
    if (idx === selected && idx !== correct) {
      btn.style.opacity = 0.5;
      btn.innerHTML = `❌ ${btn.innerText}`;
    }
  });
  if (selected === correct) score++;
}

function showResult() {
  let html = `<div class="result">Você acertou ${score} de ${questions.length}!</div>`;
  if (score === questions.length) {
    html += `<div class="result">PERFEITO! Você é FURIA raiz! 🐆🔥</div>`;
  } else if (score >= questions.length * 0.7) {
    html += `<div class="result">Mandou bem! Você conhece muito da FURIA!</div>`;
  } else if (score >= questions.length * 0.4) {
    html += `<div class="result">Legal! Mas dá pra saber mais sobre a FURIA!</div>`;
  } else {
    html += `<div class="result">Que tal acompanhar mais a FURIA? 😅</div>`;
  }
  html += `<button class="btn-restart" onclick="startQuiz()">Tentar novamente</button>`;
  document.getElementById('quiz-content').innerHTML = html;
  document.getElementById('quiz-footer').textContent = '';
}

// Iniciar quiz ao clicar no botão inicial
document.addEventListener('DOMContentLoaded', function() {
  const btnStart = document.getElementById('btn-start');
  if (btnStart) {
    btnStart.addEventListener('click', startQuiz);
  } else {
    startQuiz();
  }
});
