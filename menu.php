			<li class="nav-item nav-category">
              <span class="nav-link">Dashboard</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Cadastros</span></li>
			
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-atendentes" aria-expanded="false" aria-controls="ui-atendentes">
                <span class="menu-title">Atendentes</span>
                <i class="icon-chart menu-icon"></i>
              </a>
              <div class="collapse" id="ui-atendentes">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="atatendente.php">Atendente</a></li>					
                  <li class="nav-item"> <a class="nav-link" href="vdclcomis.php">Classificação Comissão</a></li>					
                  <li class="nav-item"> <a class="nav-link" href="vdvendedor.php">Comissionado</a></li>		  
                  <li class="nav-item"> <a class="nav-link" href="attipoatend.php">Tipo de Atendente</a></li>						  
                  <li class="nav-item"> <a class="nav-link" href="vdtipovend.php">Tipo de Vendedor</a></li>						  
				  
                </ul>
              </div>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-clientes" aria-expanded="false" aria-controls="ui-clientes">
                <span class="menu-title">Clientes</span>
                <i class="icon-globe menu-icon"></i>
              </a>
              <div class="collapse" id="ui-clientes">
                <ul class="nav flex-column sub-menu">
				  <li class="nav-item"> <a class="nav-link" href="vdclascli.php">Classificação</a></li>			
				  <li class="nav-item"> <a class="nav-link" href="fntiporestr.php">Restrição</a></li>	
                  <li class="nav-item"> <a class="nav-link" href="vdtipocli.php">Tipo de Cliente</a></li>					
                  <li class="nav-item"> <a class="nav-link" href="vdcliente.php">Clientes</a></li>		  
                </ul>
              </div>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-fornecedores" aria-expanded="false" aria-controls="ui-fornecedores">
                <span class="menu-title">Fornecedores</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
              <div class="collapse" id="ui-fornecedores">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="cptipofor.php">Tipo Fornecedor</a></li>					
                  <li class="nav-item"> <a class="nav-link" href="cpforneced.php">Fornecedores</a></li>	
				  <li class="nav-item"> <a class="nav-link" href="cpparc.php">Parceiros</a></li>					  
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-produtos" aria-expanded="false" aria-controls="ui-produtos">
                <span class="menu-title">Produtos</span>
                <i class="icon-layers menu-icon"></i>
              </a>
              <div class="collapse" id="ui-produtos">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="eqgrupo.php">Grupos</a></li>					
                  <li class="nav-item"> <a class="nav-link" href="eqproduto.php">Produtos</a></li>				  
                  <?php
					if ($sgfilial->tipoempresa !== "M") {
						echo '<li class="nav-item"> <a class="nav-link" href="eqalmox.php">Almoxarifados</a></li>';
						echo '<li class="nav-item"> <a class="nav-link" href="eqmarca.php">Marcas</a></li>';
						echo '<li class="nav-item"> <a class="nav-link" href="equnidade.php">Unidades</a></li>';
					}
				  ?>			  
                </ul>
              </div>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-outroscad" aria-expanded="false" aria-controls="ui-outroscad">
                <span class="menu-title">Outros</span>
                <i class="icon-grid menu-icon"></i>
              </a>
              <div class="collapse" id="ui-outroscad">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="fnplanopag.php">Plano de Pagamento</a></li>
				  <li class="nav-item"> <a class="nav-link" href="eqtipomov.php">Tipos de Movimento</a></li>				  
                  <li class="nav-item"> <a class="nav-link" href="vdtransp.php">Transportadores</a></li>		  
                </ul>
              </div>
            </li>	
	
     <li class="nav-item nav-category"><span class="nav-link">Oportunidades</span></li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-outrosopu" aria-expanded="false" aria-controls="ui-outrosopu">
                <span class="menu-title">Envios</span>
                <i class="icon-pencil menu-icon"></i>
              </a>  
              <div class="collapse" id="ui-outrosopu">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="vdoportunidade.php">Oportunidades</a></li>
				  <li class="nav-item"> <a class="nav-link" href="vdmapa.php">Mapa</a></li>
				  <li class="nav-item"> <a class="nav-link" href="404.php#">Leads</a></li>		
				  <li class="nav-item"> <a class="nav-link" href="404.php#">Notificações Push</a></li>		
				  <li class="divider"></li> 
                </ul>
              </div>
            </li>	
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-outroscall" aria-expanded="false" aria-controls="ui-outroscall">
                <span class="menu-title">Call Center</span>
                <i class="icon-phone menu-icon"></i>
              </a>  
              <div class="collapse" id="ui-outroscall">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="404.php">CallCenter</a></li>
				  <li class="nav-item"> <a class="nav-link" href="404.php">Leads</a></li>
                </ul>
              </div>
            </li>	            
			
            <li class="nav-item nav-category"><span class="nav-link">Movimentos</span></li>
			<?php if (($_SESSION['nivelusu'] >= 6999) AND ($_SESSION['nivelsu']< 7499)) :?>			  
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-compras" aria-expanded="false" aria-controls="ui-compras">
                <span class="menu-title">Compras</span>
                <i class="icon-social-dropbox menu-icon"></i>
              </a>
              <div class="collapse" id="ui-compras">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="cpcompra.php"> Compras</a></li> <!--CANCELAR COMPRA COMO FAZER -->
                  <li class="nav-item"> <a class="nav-link" href="cpcentral.php" > Central de Cotações</a></li>		
				  <li class="nav-item"> <a class="nav-link" href="404.php"> Ordem de Compra</a></li>				  
				  <?php
					if ($sgfilial->tipoempresa !== "M") {				  
                        echo '<li class="nav-item"> <a class="nav-link" href="lffrete.php"> Frete Avulso</a></li>';
					}
					?>
                  <li class="nav-item divider"></li> <!-- Linha divisória dentro da ul -->                  
                  <li class="nav-item"> <a class="nav-link" href="frm_cancelacompra.php"> Cancela Compras</a></li>				  
                </ul>
              </div>
			  <?php endif;?>
            </li>
			<?php if (($_SESSION['nivelusu'] >= 7499) AND ($_SESSION['nivelsu']< 7999)) :?>
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-vendas" aria-expanded="false" aria-controls="ui-vendas">
                <span class="menu-title">Vendas</span>
                <i class="icon-credit-card menu-icon"></i>
              </a>
              <div class="collapse" id="ui-vendas">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="vdvenda.php"> Vendas</a></li>
				    <?php
					if ($sgfilial->tipoempresa !== "M") {
						echo '<li class="nav-item"> <a class="nav-link" href="vdvendaentrega.php"> Entregas </a></li>';
						echo '<li class="nav-item"> <a class="nav-link" href="vdromaneio.php"> Romaneio</a></li>';
					}
					?>
                  <li class="nav-item"> <a class="nav-link" href="frm_cancelavenda.php"> Cancela Vendas</a></li>        				  
                </ul>
              </div>
			  <?php endif;?>
            </li>	
			<?php
				if ($sgfilial->tipoempresa !== "M") {
					if (($_SESSION['nivelusu'] >= 6999) AND ($_SESSION['nivelsu'] < 7499)) {
						echo '<li class="nav-item">
							<a class="nav-link" href="404.php"><span class="menu-title">Inventário</span><i class="icon-share-alt menu-icon"></i></a>
						</li>';
					}
				}
			?>
			<?php if (($_SESSION['nivelusu'] >= 7499) AND ($_SESSION['nivelsu']< 7999)) :?>			
			<li class="nav-item">
              <a class="nav-link" href="vdreceita.php">
                <span class="menu-title">Receituário</span>
                <i class="icon-speech menu-icon"></i>
              </a>
            </li>	
			<?php endif;?>
			<li class="nav-item nav-category"><span class="nav-link">Financeiro</span></li>
			<?php if ($_SESSION['nivelusu'] >= 7500) :?>				
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-pagar" aria-expanded="false" aria-controls="ui-pagar">
                <span class="menu-title">Contas a Pagar</span>
                <i class="icon-list menu-icon"></i>
              </a>
              <div class="collapse" id="ui-pagar">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="404.php"> Pagamento de Comissão </a></li>
                  <li class="nav-item"> <a class="nav-link" href="fnpagar.php"> Contas a Pagar </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-receber" aria-expanded="false" aria-controls="ui-receber">
                <span class="menu-title">Contas a Receber</span>
                <i class="icon-credit-card menu-icon"></i>
              </a>
              <div class="collapse" id="ui-receber">
                <ul class="nav flex-column sub-menu">
                  <!--<li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Pagamento de Comissão </a></li>-->
                  <li class="nav-item"> <a class="nav-link" href="fnreceber.php"> Contas a Receber </a></li>
                </ul>
              </div>
            </li>
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-outrosfin" aria-expanded="false" aria-controls="ui-outrosfin">
                <span class="menu-title">Outros</span>
                <i class="icon-grid menu-icon"></i>
              </a>
              <div class="collapse" id="ui-outrosfin">
                <ul class="nav flex-column sub-menu">
				  <li class="nav-item"> <a class="nav-link" href="fncc.php">Centro de Custos</a></li>
                  <li class="nav-item"> <a class="nav-link" href="fnconta.php">Contas</a></li>
				  <li class="nav-item"> <a class="nav-link" href="fnmodboleto.php">Modelo Boletos</a></li>				  
                  <li class="nav-item"> <a class="nav-link" href="fnplanejamento.php">Plano de Contas</a></li>		  
                </ul>
              </div>
            </li>				
			<?php endif;?>
			<li class="nav-item nav-category"><span class="nav-link">Fiscal</span></li>
			<?php
					if ($sgfilial->tipoempresa !== "M") {			
						if ($_SESSION['nivelusu'] >= 7499) {
						echo '<li class="nav-item"><a class="nav-link" data-toggle="collapse" href="#ui-regras" aria-expanded="false" aria-controls="ui-regras">
									<span class="menu-title">Regras</span>
									<i class="icon-notebook menu-icon"></i> </a>';
						echo  '<div class="collapse" id="ui-regras">
									<ul class="nav flex-column sub-menu">
										<li class="nav-item"> <a class="nav-link" href="lfregrafiscal.php"> CFOP</a></li>
										<li class="nav-item"> <a class="nav-link" href="lfclfiscal.php"> Classificação Fiscal </a></li>
									</ul>
								</div></li>';
						}
					}
			?>
			<?php if ($_SESSION['nivelusu'] >= 7499) :?>			
			<li class="nav-item">
              <a class="nav-link" href="lfmensagem.php">
                <span class="menu-title">Mensagens</span>
                <i class="icon-direction menu-icon"></i>
              </a>
            </li>
			<?php endif;?>
		  	<li class="nav-item nav-category"><span class="nav-link">Configurações</span></li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-config" aria-expanded="false" aria-controls="ui-config">
                <span class="menu-title">Perfil</span>
                <i class="icon-user menu-icon"></i>
              </a>
              <div class="collapse" id="ui-config">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="sgusuario.php"> Usuário</a></li>
                  <li class="nav-item"> <a class="nav-link" href="attarefa.php"> Tarefas </a></li>
                  <li class="nav-item"> <a class="nav-link" href="404.php"> Mensagens</a></li>	
                  <li class="nav-item"> <a class="nav-link" href="veentrevista.php"> Entrevistas</a></li>	                  
                </ul>
              </div>
            </li>
			
			<?php if ($_SESSION['nivelusu'] >= 9900) :?>
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-nono" aria-expanded="false" aria-controls="ui-nono">
                <span class="menu-title">NonoElemento</span>
                <i class="icon-game-controller menu-icon"></i>
              </a>
			  <div class="collapse" id="ui-nono">
                <ul class="nav flex-column sub-menu">
				  <li class="nav-item"> <a class="nav-link" href="sgempresa.php"> Empresas </a></li>
                  <li class="nav-item"> <a class="nav-link" href="tai_emp_servicos.php"> Serviços </a></li>
                  <li class="nav-item"> <a class="nav-link" href="sgrecado.php"> Recados </a></li>
                  <li class="nav-item"> <a class="nav-link" href="sgrevenda.php"> Revendas </a></li>
                  <li class="nav-item"> <a class="nav-link" href="ticket.php"> Tickets</a></li>				  
                  <li class="nav-item"> <a class="nav-link" href="veentrevista.php"> Entrevistas</a></li>
                  <li class="nav-item"> <a class="nav-link" href="sgversao.php"> Versões</a></li>						  
                </ul>
              </div>
            </li>
			<?php endif;?>	
			
			
			<li class="nav-item">
              <a class="nav-link" href="404.php">
                <span class="menu-title">Preferências</span>
                <i class="icon-settings menu-icon"></i>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="logout.php">
                <span class="menu-title">Finalizar</span>
                <i class="icon-power menu-icon"></i>
              </a>
            </li>
          </ul>