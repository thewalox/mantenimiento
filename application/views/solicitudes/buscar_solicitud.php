	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Solicitudes</a></li>
						<li class="active">Buscar Solicitudes</li>
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
						    	<div class="form-group col-md-2">
									<label for="estado">Estado</label>
									<select class="form-control input-sm" name="estado" id="estado">
										<option value="0">Todas</option>
										<option value="P">En Proceso</option>
										<option value="C">Cerrada</option>
									</select>
								</div>
								<div class="form-group col-md-2">
									<label for="servicio">Servicio</label>
									<select class="form-control input-sm" name="servicio" id="servicio">
										<option value="0">...</option>
										<option value="IN">Inmediato</option>
										<option value="NI">No Inmediato</option>
									</select>
								</div>
								<div class="form-group col-md-2">
									<label for="tipo">Tipo Mantenimiento</label>
									<select class="form-control input-sm" name="tipo" id="tipo">
										<option value="0">...</option>
										<option value="P">Preventivo</option>
										<option value="C">Correctivo</option>
									</select>
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
						<div><a href='<?php echo base_url(); ?>solicitudes/exportar' id='exportar' title='Exportar a Excel'><img src='<?php echo base_url(); ?>assets/img/excel.png' width='20px' height='20px' /></a></div>
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Servicio</th>
									<th>Tipo Mantenimiento</th>
									<th>Estado</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($solicitud as $sol) {
									# code...
							?>
							<tr class="<?php echo $sol["color"]; ?>">
								<td><?php echo $sol["idsolicitud"]; ?></td>
								<td><?php echo $sol["fecha_solicitud"]; ?></td>
								<td><?php echo $sol["servicio"]; ?></td>
								<td><?php echo $sol["tipo_mtto"]; ?></td>
								<td><?php echo $sol["estado"]; ?></td>
								<td><a href="<?php echo base_url('solicitudes/form_ver/'. $sol["idsolicitud"]); ?>"><span class="glyphicon glyphicon-search"></span></a></td>
								<td><?php if($sol["estado"] == 'EN PROCESO'){ ?><a href="<?php echo base_url('solicitudes/form_editar/'. $sol["idsolicitud"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a><?php } ?></td>
								<td><?php if($sol["estado"] == 'EN PROCESO'){ ?><a href="<?php echo base_url('solicitudes/eliminar_solicitud/'. $sol["idsolicitud"]); ?>"><span class="glyphicon glyphicon-trash"></span></a><?php } ?></td>
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
				var estado = $("#estado").val();
				var servicio = $("#servicio").val();
				var tipo = $("#tipo").val();
				var idmaq = $("#idmaq").val();

				var html = "";
				var reg = 0;

				var $btn = $(this).button('loading');

				$.ajax({
			    	type:"GET",
			    	url:"<?php echo base_url('solicitudes/get_solicitudes_criterio'); ?>",
			    	data:{
			    		'id'		: 	id,
			    		'fecsol'	: 	fecsol,
			    		'estado'	: 	estado,
			    		'servicio'	: 	servicio,
			    		'tipo'		: 	tipo,
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
						html += "<th>id</th>";
						html += "<th>Fecha</th>";
						html += "<th>Servicio</th>";
						html += "<th>Tipo Mantenimiento</th>";
						html += "<th>Estado</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr class='"+ json[datos].color +"'>";
								html +=	"<td>" + json[datos].idsolicitud + "</td>";
								html +=	"<td>" + json[datos].fecha_solicitud + "</td>";
								html +=	"<td>" + json[datos].servicio + "</td>";
								html +=	"<td>" + json[datos].tipo_mtto + "</td>";
								html +=	"<td>" + json[datos].estado + "</td>";
								html +=	"<td><a href='<?php echo base_url('solicitudes/form_ver/" + json[datos].idsolicitud  + "'); ?>'><span class='glyphicon glyphicon-search'></span></a></td>";
								html +=	"<td>"; 
								if (json[datos].estado == 'EN PROCESO') { 
									html +=	"<a href='<?php echo base_url('solicitudes/form_editar/" + json[datos].idsolicitud  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a>" 
								} 
								html += "</td>";
								html +=	"<td>"; 
								if (json[datos].estado == 'EN PROCESO') { 
									html += "<a href='<?php echo base_url('solicitudes/eliminar_seccion/" + json[datos].idsolicitud  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a>";
								}
								html += "</td>";
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