                <div class="card">
                  <div class="card-body">
				  <?php if ($_SESSION['nivelusu'] >= 7499) :?> 
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Resumo do Relatório</h5> <span class="ml-auto">Atualizar</span> <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                      <div class=" col-md -6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Total Vendas</span>
                          <h4>R$ <?=$conta_total_vendas?></h4>
                          <!--<span class="report-count"> 2 Reports</span>-->
                        </div>
                        <div class="inner-card-icon bg-success">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Total Pedidos</span>
                          <h4><?=$conta_total_pedidos?></h4>
                          <!--<span class="report-count"> 3 Reports</span>-->
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-briefcase"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Qtd. Itens</span>
                          <h4><?=$conta_total_itens?></h4>
                          <!--<span class="report-count"> 5 Reports</span>-->
                        </div>
                        <div class="inner-card-icon bg-warning">
                          <i class="icon-globe-alt"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">Ticket Médio</span>
                          <h4><?=$resultado?></h4>
                          <!--<span class="report-count"> 9 Reports</span>-->
                        </div>
                        <div class="inner-card-icon bg-primary">
                          <i class="icon-diamond"></i>
                        </div>
                      </div>
                    </div>
					<?php endif;?>
                  </div>
                </div>
