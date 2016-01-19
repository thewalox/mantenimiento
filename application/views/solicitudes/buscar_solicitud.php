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
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'solicitudes/form_buscar'; ?>';">
      						</span>
    					</div>
					</div>
				</div>
				<div class="form-group" id="content">
					<form name="form">
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
								<td><?php if($sol["estado"] == 'PENDIENTE'){ ?><a href="<?php echo base_url('solicitudes/form_editar/'. $sol["idsolicitud"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a><?php } ?></td>
								<td><?php if($sol["estado"] == 'PENDIENTE'){ ?><a href="<?php echo base_url('solicitudes/eliminar_solicitud/'. $sol["idsolicitud"]); ?>"><span class="glyphicon glyphicon-trash"></span></a><?php } ?></td>
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
				var filtro = $("#filtro").val();
				//alert("ok");
			    $.ajax({
			    	type:"GET",
			    	url:"<?php echo base_url('Solicitudes/get_Solicitudes_criterio'); ?>",
			    	data:{
			    		'filtro'	: 	filtro
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
			    		var html = "";
						html += "<table class='table table-striped table-condensed table-hover'>";
						html += "<thead>";
						html += "<tr>";
						html += "<th>Codigo</th>";
						html += "<th>Descripcion Seccion</th>";
						html += "<th>Planta</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].idseccion + "</td>";
								html +=	"<td>" + json[datos].desc_seccion + "</td>";
								html +=	"<td>" + json[datos].desc_planta + "</td>";
								html +=	"<td><a href='<?php echo base_url('Solicitudes/form_editar/" + json[datos].idseccion  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td><a href='<?php echo base_url('Solicitudes/eliminar_seccion/" + json[datos].idseccion  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
								html += "</tr>";
						
							}
						
						html += "</table>";
						
						$("#content").html(html);

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>	