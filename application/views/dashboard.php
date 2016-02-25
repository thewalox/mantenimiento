<div class="container">
	<div class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">Solicitudes</div>
			<div class="panel-body">
				<?php
					foreach ($totales as $total) {
				?>
				<ul class="list-group">
				 	<li class="list-group-item active"><?php echo $total["estado"] ?><span class="badge"><?php echo number_format($total["total"],0,".",","); ?></span></li>
				</ul>
				<?php
					}
				?>		
			</div>
		</div>
	</div>
</div>