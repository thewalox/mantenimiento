	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Pendientes</a></li>
						<li class="active">Buscar Pendientes</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="panel panel-primary">
						<div class="panel-heading">Seleccione Filtros</div>
					  		<div class="panel-body">
					  			<div class="col-md-2">
									<label for="id">Id Solicitud</label>
									<input type="text" placeholder="Id Solicitud" id="id" name="id" class="form-control input-sm">
								</div>
								<div class="form-group col-md-2">
									<label for="fecsol">Fecha</label>
									<div class='input-group date' id='datetimepicker1'>
					                    <input type='text' class="form-control input-sm" name="fecsol" id="fecsol" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					            	</div>
								</div>								
								<div class="col-md-2">
									<label for="idmaq">Id Maquina</label>
									<input type="text" placeholder="Id Maquina" id="idmaq" name="idmaq" class="form-control input-sm">
								</div>
					  		</div>
					</div>
					<div align="center"><input type="button" name="aceptar" id="aceptar" value="Filtrar" class="btn btn-primary" data-loading-text="Buscando..." autocomplete="off"></div>
					
				</form>
				<br>

				<div class="form-group" id="content">
					<form name="form">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th>Solicitud</th>
									<th>Fecha</th>
									<th>Tarea Pendiente</th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($pendientes as $pen) {
									# code...
							?>
							<tr>
								<td><?php echo $pen["idsolicitud"]; ?></td>
								<td><?php echo $pen["fecha_solicitud"]; ?></td>
								<td><?php echo $pen["pendiente"]; ?></td>
								<td><a href="<?php echo base_url('solicitudes/form_editar_pendientes/'. $pen["idsolicitud"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
							</tr>
							<?php
								}
							?>
						</table>
					</form>
					<div class="row">
						<div class="container">
							<ul class="pagination">
				            <?php
				              /* Se imprimen los números de página */           
				              echo $this->pagination->create_links();
				            ?>
		            		</ul>
						</div>
					</div>		
				</div>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var id = $("#id").val();
				var fecsol = $("#fecsol").val();
				var idmaq = $("#idmaq").val();

				var html = "";
				var reg = 0;

				var $btn = $(this).button('loading');

				$.ajax({
			    	type:"GET",
			    	url:"<?php echo base_url('solicitudes/get_pendientes_criterio'); ?>",
			    	data:{
			    		'id'		: 	id,
			    		'fecsol'	: 	fecsol,
			    		'idmaq'		: 	idmaq
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
			    		var html = "";
						html += "<table class='table table-striped table-condensed table-hover'>";
						html += "<thead>";
						html += "<tr>";
						html += "<th>Solicitud</th>";
						html += "<th>Fecha</th>";
						html += "<th>Tarea Pendiente</th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].idsolicitud + "</td>";
								html +=	"<td>" + json[datos].fecha_solicitud + "</td>";
								html +=	"<td>" + json[datos].pendiente + "</td>";
 								html +=	"<td><a href='<?php echo base_url('solicitudes/form_editar_pendientes/" + json[datos].idsolicitud  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html += "</tr>";
						
							}
						
						html += "</table>";
						
						$("#content").html(html);
						$btn.button('reset');

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>	