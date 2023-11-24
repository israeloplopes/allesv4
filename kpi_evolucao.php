			<div class="col-md-8 grid-margin stretch-card">
                <div class="card">
				  <?php if ($_SESSION['nivelusu'] >= 8499) :?> 
                  <div class="card-body performane-indicator-card">
                    <div class="d-sm-flex">
                      <h4 class="card-title flex-shrink-1">Evolução de Vendas</h4>
                      <p class="m-sm-0 ml-sm-auto flex-shrink-0">
                        <span class="data-time-range ml-0">07d</span>
                        <span class="data-time-range active">15d</span>
                        <span class="data-time-range">01m</span>
                        <span class="data-time-range">03m</span>
                        <span class="data-time-range">06m</span>
						<span class="data-time-range">12m</span>
                      </p>
                    </div>
                    <div class="d-sm-flex flex-wrap">
                      <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-primary ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold">Ticket Médio ($$qtd$$)</p>
                      </div>
                      <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-info ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold"> Recorrentes ($$qtd$$)</p>
                      </div>
                      <div class="d-flex align-items-center">
                        <span class="dot-indicator bg-danger ml-2"></span>
                        <p class="mb-0 ml-2 text-muted font-weight-semibold">Novos Clientes ($$qtd$$)</p>
                      </div>
                    </div>
                    <div id="performance-indicator-chart" class="ct-chart mt-4"></div>
                  </div>
				  <?php endif;?>
                </div>
              </div>