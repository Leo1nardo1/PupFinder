<?php
// Mensagem de erro ou de sucesso. Utilizada no cadastro e ao completar o Login
  if(isset($_SESSION['message'])){
    echo "<div id='messageContainer' style='text-align: center;'><h5 style='color: white; display: inline-block;'>".$_SESSION['message']."</h5></div>";
    unset($_SESSION['message']);
  }
?>

<!-- Mensagem desaparece após 5 segundos -->
<script>
  setTimeout(function() {
    var messageContainer = document.getElementById('messageContainer');
    if (messageContainer) {
      messageContainer.style.display = 'none';
    }
  }, 5000); 
</script>