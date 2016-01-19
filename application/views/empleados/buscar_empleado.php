	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Empleados</a></li>
						<li class="active">Buscar Empleados</li>
					</ol>
				</div>
				
				<div class="row">
					<div class="container">
						<div class="input-group">
							<input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por.....">
							<span class="input-group-btn">
					        	<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					        	<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'empleados/form_buscar'; ?>';">
      						</span>
    					</div>
					</div>
				</div>
				<div class="form-group" id="content">
					<form name="form">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th>Cedula</th>
									<th>Nombre</th>
									<th>Departamento</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<?php
								foreach ($empleado as $emp) {
									# code...
							?>
							<tr>
								<td><?php echo $emp["idempleado"]; ?></td>
								<td><?php echo $emp["nombre"]; ?></td>
								<td><?php echo $emp["desc_departamento"]; ?></td>
								<td><a href="<?php echo base_url('empleados/form_editar/'. $emp["idempleado"]); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="<?php echo base_url('empleados/eliminar_empleado/'. $emp["idempleado"]); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
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
			    	url:"<?php echo base_url('empleados/get_empleados_criterio'); ?>",
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
						html += "<th>Cedula</th>";
						html += "<th>Nombre</th>";
						html += "<th>Departamento</th>";
						html += "<th></th>";
						html += "<th></th>";
						html += "</tr>";
						html += "</thead>";
						
							for(datos in json){
								html += "<tr>";
								html +=	"<td>" + json[datos].idempleado + "</td>";
								html +=	"<td>" + json[datos].nombre + "</td>";
								html +=	"<td>" + json[datos].desc_departamento + "</td>";
								html +=	"<td><a href='<?php echo base_url('empleados/form_editar/" + json[datos].idempleado  + "'); ?>'><span class='glyphicon glyphicon-pencil'></span></a></td>";
								html +=	"<td><a href='<?php echo base_url('empleados/eliminar_empleado/" + json[datos].idempleado  + "'); ?>'><span class='glyphicon glyphicon-trash'></span></a></td>";
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