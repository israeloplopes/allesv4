			<li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/faces/<?=$_SESSION['foto']?>" alt="Alles">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
				  <?php

					$codfuncao = $_SESSION['nivelusu'];
					
					if($codfuncao >=1000 && $codfuncao<2000) {
						$funcao = "Estoquista";}
					else if ($codfuncao >=2000 && $codfuncao<3000 ){
						$funcao = "Atendente";}
					else if ($codfuncao >=3000 && $codfuncao<4000 ){
						$funcao = "Bom dia";}		
					else if ($codfuncao >=4000 && $codfuncao<5000 ){
						$funcao = "Financeiro";}	
					else if ($codfuncao >=5000 && $codfuncao<6000 ){
						$funcao = "Vendedor";}
					else if ($codfuncao >=6000 && $codfuncao<7000 ){
						$funcao = "Gerente";}	
					else if ($codfuncao >=7000 && $codfuncao<8000 ){
						$funcao = "Administrativo";}							
					else {
					$funcao = "Desenvolvimento";}
		
				  ?>
                  <p class="profile-name"><?=$_SESSION['usuario'];?></p>
                  <p class="designation"><?=$funcao;?></p>
                </div>
                <div class="icon-container">
                  <i class="icon-bubbles"></i>
                  <div class="dot-indicator bg-danger"></div>
                </div>
              </a>
            </li>