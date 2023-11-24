<?php

    date_default_timezone_set('America/Sao_Paulo');
   	include '../../db/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Alles é tudo!</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../css/style.css" <!-- End layout styles -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    
    	<script>

        function formatarCPF(cpf) {
            cpf = cpf.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11);
            }
            
            var formattedCPF = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            
            return formattedCPF;
        }

        function validarCPF() {
            var cpfInput = document.getElementById('cpf');
            var cpf = cpfInput.value;
            cpf = cpf.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) {
                return false;
            }

            var sum = 0;
            var remainder;

            for (var i = 1; i <= 9; i++) {
                sum = sum + parseInt(cpf.substring(i - 1, i)) * (11 - i);
            }

            remainder = (sum * 10) % 11;

            if ((remainder === 10) || (remainder === 11)) {
                remainder = 0;
            }

            if (remainder !== parseInt(cpf.substring(9, 10))) {
                alert('CPF inválido');
                cpfInput.Value = '';
                return false;
            }

            sum = 0;
            for (i = 1; i <= 10; i++) {
                sum = sum + parseInt(cpf.substring(i - 1, i)) * (12 - i);
            }

            remainder = (sum * 10) % 11;

            if ((remainder === 10) || (remainder === 11)) {
                remainder = 0;
            }

            if (remainder !== parseInt(cpf.substring(10, 11))) {
                alert('CPF inválido');
                cpfInput.Value = '';
                return false;
            }

            cpfInput.value = formatarCPF(cpf); // Formata o CPF no campo

            return true;
        }
        
        function validarFormCPF() {
            var cpfInput = document.getElementById('cpf');
            var cpf = cpfInput.value;
            var cpfValido = validarCPF(cpf);
            
            if (cpfValido) {
                cpfInput.classList.remove('invalido');
                cpfInput.classList.add('valido');
            } else {
                cpfInput.classList.remove('valido');
                cpfInput.classList.add('invalido');
            }
        }
        
        function formatarDataInput(input) {
          var valor = input.value;
            valor = valor.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

            // Verifica se o valor está vazio ou possui menos de 8 dígitos (não é possível formatar)
            if (valor === '' || valor.length < 8) {
                return;
            }

            // Formata a data no formato DD/MM/AAAA
            var dia = valor.substring(0, 2);
            var mes = valor.substring(2, 4);
            var ano = valor.substring(4, 8);
    
            input.value = dia + '/' + mes + '/' + ano;
        }

        function preencherNomeCli() {
          var razcli = document.getElementById('razcli').value;
          var nomecli = razcli.split(' ')[0];

          document.getElementById('nomecli').value = nomecli;
        }
        
        function formatarCNPJInput(input) {
            var cnpj = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            var formatted = cnpj;

            if (formatted.length > 2) {
              formatted = formatted.replace(/^(\d{2})/, '$1.');
            }
            if (formatted.length > 6) {
                formatted = formatted.replace(/^(\d{2})(\d{3})/, '$1.$2.');
            }
            if (formatted.length > 10) {
                formatted = formatted.replace(/^(\d{2})(\d{3})(\d{3})/, '$1.$2.$3/');
            }
            if (formatted.length > 15) {
                formatted = formatted.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})/, '$1.$2.$3/$4-');
            }
            input.value = formatted;
        }

        function validarCNPJ(cnpjInput) {
            var cnpj = cnpjInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            var mensagem = document.getElementById('cnpj-validation');

            if (cnpj.length !== 14 || !validarDigitosCNPJ(cnpj)) {
                mensagem.textContent = 'CNPJ inválido';
                cnpjInput.setCustomValidity('CNPJ inválido');
                cnpjInput.focus();
                } else {
                mensagem.textContent = '';
                cnpjInput.setCustomValidity('');
            }
        }

        function validarDigitosCNPJ(cnpj) {
            var multiplicador1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            var multiplicador2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            var soma = 0;
            var resto;

            for (var i = 0; i < 12; i++) {
                soma += parseInt(cnpj.charAt(i)) * multiplicador1[i];
            }
            resto = (soma % 11);
            if (resto < 2) {
                resto = 0;
                } else {
                resto = 11 - resto;
            }
            if (resto !== parseInt(cnpj.charAt(12))) {
                return false;
            }
            soma = 0;
            for (i = 0; i < 13; i++) {
                soma += parseInt(cnpj.charAt(i)) * multiplicador2[i];
            }
            resto = (soma % 11);
            if (resto < 2) {
                resto = 0;
                } else {
                resto = 11 - resto;
            }
            if (resto !== parseInt(cnpj.charAt(13))) {
                return false;
            }
            return true;
        }

        function formatarTelefone(input) {
            // Remove todos os caracteres não numéricos do valor
            var numero = input.value.replace(/\D/g, '');
            // Verifica se o número possui 10 ou 11 dígitos e aplica a formatação adequada
            if (numero.length === 10) {
                numero = numero.replace(/(\d{2})(\d{4})(\d{4})/, '($1)$2-$3');
                } else if (numero.length === 11) {
                numero = numero.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
            }

            // Atualiza o valor do campo de entrada com o número formatado
            input.value = numero;
        }

    </script>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="../../images/logo.svg">
                </div>
                <h4>Quer saber mais sobre o Alles?</h4>
                <h6 class="font-weight-light">Preencha o formulário que nossa equipe entrará em contato</h6>
                <form class="pt-3" action="../forms/act_registro.php" method="post" enctype="multipart/form-data">>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="nomecontato" placeholder="Seu nome" onChange="javascript:this.value=this.value.toUpperCase();" autofocus required;>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="emailcontato" placeholder="Email" onChange="javascript:this.value=this.value.toLowerCase();" required;>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="telcontato" placeholder="Telefone"  oninput="formatarTelefone(this)" required;>
                  </div>				  
                  <div class="form-group">
                    <select class="form-control form-control-lg" id="porteempresa">
                      <option>até 2 usuários</option>
                      <option>até 5 usuários</option>
                      <option>até 9 usuários</option>
                      <option>Acima de 10 usuários</option>
                    </select>
                  </div>
				  <div class="form-group">
                    <select class="form-control form-control-lg" id="regimeempresa">
                      <option>MEI/Simples Nacional</option>
                      <option>Lucro Presumido</option>
                      <option>Lucro Real</option>
                    </select>
                  </div>
				  
				  <!--
				  ###
				  ACRESCENTAR CAMPO SELECT COM OS ESTADOS
				  ###
				  -->
				  
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="cidadecontato" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" required>
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                     <!-- <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>-->
                    </div>
                  </div>
                  <div class="mt-3">
                    <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.php">ENVIAR</a>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Já tem uma conta? <a href="login.php" class="text-primary">Acesse</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/misc.js"></script>
    <!-- endinject -->
  </body>
</html>