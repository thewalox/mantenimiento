	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Maquinas</a></li>
						<li class="active">Buscar Maquinas</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'maquinas/form_buscar'; ?>';">
      						</span>
    					</div>
					</div>
				</div>
				<div class="form-group" id="content">
					<form name="form">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>Descripcion Maquina</th>
									<th>Seccion</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Serial</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($maquina as $maq) {
									# code...
							?>
							<tr>
								<td><?php echo $maq["idmaquina"]; ?></td>
								<td><?php echo $maq["desc_maquina"]; ?></td>
								<td><?php echo $maq["desc_seccion"]; ?></td>
								<td><?php echo $maq["marca"]; ?></td>
								<td><?php echo $maq["modelo"]; ?></td>
								<td><?php echo $maq["serial"]; ?></td>
								<td><a href="<?php echo base_url('maquinas/form_editar/'. $maq["idmaquina"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="<?php echo base_url('maquinas/eliminar_maquina/'. $maq["idmaquina"]); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
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
			    	url:"<?php echo base_url('maquinas/get_maquinas_criterio'); ?>",
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
						html += "<th>Descripcion Maquina</th>";
						html += "<th>Seccion</th>";
						html += "<th>Marca</th>";
						html += "<th>Modelo</th>";
						html += "<th>Serial</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].idmaquina + "</td>";
								html +=	"<td>" + json[datos].desc_maquina + "</td>";
								html +=	"<td>" + json[datos].desc_seccion + "</td>";
								html +=	"<td>" + json[datos].marca + "</td>";
								html +=	"<td>" + json[datos].modelo + "</td>";
								html +=	"<td>" + json[datos].serial + "</td>";
								html +=	"<td><a href='<?php echo base_url('maquinas/form_editar/" + json[datos].idmaquina  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td><a href='<?php echo base_url('maquinas/eliminar_maquina/" + json[datos].idmaquina  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
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