<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$userId = $_SESSION['user_id'];
// Fetch 20 questions
$conn = new mysqli('localhost', 'root', '', 'quiz_proj');
$res = $conn->query("SELECT * FROM questions ORDER BY RAND() LIMIT 20");
$q_arr = $res->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz</title>
  <style>
    /* Same improved CSS as before */
    body { font-family: Arial; background: #eef; margin:0; }
    .container{display:flex;height:100vh;}
    .question-list-container{width:200px;padding:10px;}
    .question-list{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;list-style:none;padding:0;}
    .question-list li{width:40px;height:40px;border:2px solid #00796b;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;}
    .question-list li.answered{background:#c8e6c9;pointer-events:none;color:#004d40;}
    .question-list li:hover{background:#004d40;color:#fff;}
    .quiz-container{flex:1;padding:20px;}
    h1{text-align:center;color:#00796b;}
    .timer{text-align:center;font-size:24px;color:#e65100;}
    .question{font-size:18px;margin:20px 0;}
    .options label{display:block;margin:8px 0;}
    .buttons-container{display:flex;justify-content:space-between;margin-top:20px;}
    .preview-button, .submit-button{padding:10px 20px;border:none;border-radius:4px;color:#fff;cursor:pointer;}
    .preview-button{background:#ffa000;}
    .preview-button:hover{background:#ff6f00;}
    .submit-button{background:#388e3c;}
    .submit-button:hover{background:#2e7d32;}
  </style>
</head>
<body>
<div class="container">
  <div class="question-list-container">
    <ul id="question-list" class="question-list"></ul>
  </div>
  <div class="quiz-container">
    <h1>MCQ Quiz</h1>
    <div class="timer">Time Left: <span id="time">00:20:00</span></div>
    <form id="quiz-form">
      <div class="question" id="question"></div>
      <div class="options"></div>
      <div class="buttons-container">
        <button type="button" class="preview-button" onclick="prevQ()">Previous</button>
        <button type="button" class="submit-button" onclick="nextQ()">Submit</button>
      </div>
    </form>
  </div>
</div>

<script>
const questions = <?= json_encode($q_arr) ?>;
let current = 0, answers = Array(questions.length).fill(null);
let totalTime = 20 * 60;

function loadList() {
  const list = document.getElementById('question-list');
  questions.forEach((q,i) => {
    const li = document.createElement('li');
    li.innerText = i+1;
    li.id = 'q'+i;
    li.onclick = ()=>{loadQ(i)};
    list.appendChild(li);
  });
}
function loadQ(i){
  current = i;
  document.getElementById('question').innerHTML = `<b>Q${i+1}:</b> ${questions[i].question}`;
  const opts = ['opt_a','opt_b','opt_c','opt_d'].map(k=>questions[i][k]);
  document.querySelector('.options').innerHTML = opts.map(o=>`
    <label><input type="radio" name="ans" value="${o}" ${answers[i]===o?'checked':''}> ${o}</label>
  `).join('');
}
function prevQ(){ if(current>0) loadQ(current-1); }
function nextQ(){
  const sel = document.querySelector('input[name="ans"]:checked');
  if(sel) {
    answers[current] = sel.value;
    document.getElementById('q'+current).classList.add('answered');
  }
  if(current < questions.length-1) loadQ(current+1);
  else finishQuiz();
}

function formatTime(s){
  const h=String(Math.floor(s/3600)).padStart(2,'0'),
        m=String(Math.floor((s%3600)/60)).padStart(2,'0'),
        sec=String(s%60).padStart(2,'0');
  return `${h}:${m}:${sec}`;
}

function timerTick(){
  totalTime--;
  if(totalTime < 0) return finishQuiz();
  document.getElementById('time').innerText = formatTime(totalTime);
}
setInterval(timerTick,1000);

function finishQuiz(){
  document.removeEventListener('visibilitychange',ievent);
  clearInterval();
  fetch('submit.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({answers,ids:questions.map(q=>q.id),user:<?= $userId ?>})})
      .then(()=>window.location='dashboard.php');
}

function ievent(){
  if(document.visibilityState!=='visible') finishQuiz();
}

window.onload = ()=>{ loadList(); loadQ(0);
  document.addEventListener('visibilitychange', ievent);
  document.body.requestFullscreen && document.body.requestFullscreen();
};
</script>
</body>
</html>
