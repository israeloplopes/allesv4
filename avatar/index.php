<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pergunta Interativa</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <img src="avatar.png" alt="Avatar" class="avatar">
  <div class="container">
    <div class="question">
      <h3> Oi, eu sou o IaaN</h3>
      <input type="text" id="pergunta" placeholder="Faça uma pergunta">
      <button class="btn-ok" onclick="enviarPergunta()">OK</button>
    </div>
  </div>

  <script>
    function enviarPergunta() {
      const pergunta = document.getElementById('pergunta').value;
      if (pergunta) {
        const mensagem = encodeURIComponent(`Nova pergunta Iaan [Alles4]: ${pergunta}`);
        window.open(`https://api.whatsapp.com/send?phone=5527997996139&text=${mensagem}`);
      }
    }
  </script>  
</body>
</html>
