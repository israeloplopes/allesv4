              <div class="col-12 stretch-card grid-margin">
                <div class="card card-secondary">
				  <?php if(!empty($rs_sgrecado)):?>
					<?php foreach($rs_sgrecado as $sgrecado):?>
                  <span class="card-body d-lg-flex align-items-center">
					<p class="mb-lg-0"><b><?=$sgrecado->assunto;?></b> | <?=$sgrecado->mensagem;?></p>
                    <a href="https://www.bootstrapdash.com/product/stellar-admin/?utm_source=organic&utm_medium=banner&utm_campaign=free-preview" target="_blank" class="btn btn-warning purchase-button btn-sm my-1 my-sm-0 ml-auto">Marcar como lida</a>
                    <button class="close popup-dismiss ml-2">
                      <span aria-hidden="true">&times;</span>
                    </button>
					 <?php endforeach;?>	
                  </span>
			  	<?php else: ?>
				<?php endif; ?>
                </div>
              </div>
