                <div class="card">
                  <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Ações Rápidas</h5>
                    <p class="ml-auto mb-0">Atalhos para funções mais usadas<i class="icon-bulb"></i></p>
                  </div>
                  <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0"> <i class="icon-user mr-2"></i> Adiciona Cliente</button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0"><a href="frm_attarefa.php"><i class="icon-docs mr-2"></i> Adiciona Tarefa</a></button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <?php if ($_SESSION['nivelusu'] >= 7999) :?>
						<button type="button" class="btn px-0"><i class="icon-folder mr-2"></i> Adiciona Contas a Receber</button>
					  <?php endif;?>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
						<?php if (($_SESSION['nivelusu'] >= 7499) and ($_SESSION['nivelusu'] <7999)) :?>
							<button type="button" class="btn px-0"><i class="icon-book-open mr-2"></i>Adiciona Venda</button>
						<?php endif;?>
                    </div>
                  </div>
                </div>