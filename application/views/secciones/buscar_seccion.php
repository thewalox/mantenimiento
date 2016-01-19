	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Secciones</a></li>
						<li class="active">Buscar Secciones</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'secciones/form_buscar'; ?>';">
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
									<th>Descripcion Seccion</th>
									<th>Planta</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($seccion as $sec) {
									# code...
							?>
							<tr>
								<td><?php echo $sec["idseccion"]; ?></td>
								<td><?php echo $sec["desc_seccion"]; ?></td>
								<td><?php echo $sec["desc_planta"]; ?></td>
								<td><a href="<?php echo base_url('secciones/form_editar/'. $sec["idseccion"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="<?php echo base_url('secciones/eliminar_seccion/'. $sec["idseccion"]); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
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
			    	url:"<?php echo base_url('secciones/get_secciones_criterio'); ?>",
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
								html +=	"<td><a href='<?php echo base_url('secciones/form_editar/" + json[datos].idseccion  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td><a href='<?php echo base_url('secciones/eliminar_seccion/" + json[datos].idseccion  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
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