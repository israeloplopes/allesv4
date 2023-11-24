                <div class="card">
                  <div class="card-body">
				    <?php if ($_SESSION['nivelusu'] >= 7499) :?> 
                    <div class="d-sm-flex align-items-center mb-4">
                      <h4 class="card-title mb-sm-0">Últimas Vendas</h4>
                      <!--<a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Products</a>-->
                    </div>
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">ID|Cliente</th>
                            <th class="font-weight-bold">Total</th>
                            <th class="font-weight-bold">Forma Pagto</th>
                            <th class="font-weight-bold">Efetuado em</th>
                            <th class="font-weight-bold">Tipo</th>
							<th class="font-weight-bold">Vendedor</th>
                            <th class="font-weight-bold">Status</th>
                          </tr>
                        </thead>
                        <tbody>
						  <?php if(!empty($rs_vdvenda)):?>	
					      <?php foreach($rs_vdvenda as $vdvenda):?>						
                          <tr>
                            <td><?=str_pad($vdvenda->codcli,4,0, STR_PAD_LEFT)?>-<?=substr($vdvenda->nomecli,0,25)?></td>
                            <td><?=formata_dinheiro($vdvenda->vlrliqvenda)?></td>
                            <td><?=$vdvenda->descplanopag?></td>
                            <td><?=date("d-m-Y",strtotime($vdvenda->dtemitvenda))?></td>
                            <td><?=$vdvenda->codtipomov?></td>
                            <td><?=substr($vdvenda->nomevend,0,13)?></td>
							<td>teste</td>
                          </tr>
						<?php endforeach;?>	
						</tbody>
					</table>
					<?php else: ?>
						<h4><i class="fa fa-angle-right"></i> Não há dados localizados</h4>
					<?php endif; ?>
                    </div>
					<?php endif;?>
                  </div>
                </div>