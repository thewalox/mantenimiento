	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Empleados</a></li>
						<li class="active">Editar Empleados</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					
					<div class="form-group">
						<label for="cedula">Cedula</label>
						<input type="text" placeholder="Cedula" id="cedula" name="cedula" value="<?php echo $empleado->idempleado; ?>" class="form-control" disabled>
					</div>
					
					<div class="form-group">
						<label for="descripcion">Nombre</label>
						<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" value="<?php echo $empleado->nombre; ?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="departamento">Departamento</label>
						<select class="form-control" name="dep" id="dep">
							<option value="0">...</option>
							<?php 
								foreach($departamento as $dep){
							?>
                				<option value="<?php echo $dep['iddepartamento']; ?>" <?php if($dep["iddepartamento"] == $empleado->iddepartamento){ ?> selected="selected" <?php } ?>><?php echo $dep['desc_departamento']; ?></option>
            				<?php 
            					}
            				?>
						</select>
						<div class="checkbox">
							<label>
						    	<input type="checkbox" id="tecnico" name="tecnico" <?php if($empleado->tecnico == 'S'){?> checked <?php } ?>> Marque solo si el empleado es un tecnico
							</label>
						</div>
					</div>
										
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					<input type="button" name="regresar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'empleados/form_buscar'; ?>';">

				</form>
				
				
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var cedula = $("#cedula").val();
				var nombre = $("#nombre").val();
				var dep = $("#dep").val();
				var tecnico = "";

				if( $('#tecnico').prop('checked') ) {
				    tecnico = 'S';
				}else{
					tecnico = 'N';
				}
				
			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('empleados/editar_empleado'); ?>",
			    	data:{
			    		'cedula'	: 	cedula,
			    		'nombre'	: 	nombre,
			    		'dep'		: 	dep,
			    		'tecnico'	: 	tecnico
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Empleado Modificado Exitosamente!!!!!</div>";
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar modificar este empleado. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
						}else{
								html += "<div class='alert alert-danger' role='alert'>" + json.mensaje + "</div>";
						}
						

						$("#content").html(html);

			    	},
			    	error:function(jqXHR, textStatus, errorThrown){
			    		console.log('Error: '+ errorThrown);
			    	}
			    });

			});
				
		});
	</script>