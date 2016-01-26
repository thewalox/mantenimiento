	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Maquinas</a></li>
						<li class="active">Crear Maquinas</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content"></div>
					
					<div class="form-group">
						<label for="codigo">Codigo</label>
						<input type="text" placeholder="Codigo" id="codigo" name="codigo" class="form-control">
					</div>

					<div class="form-group">
						<label for="descripcion">Descripcion</label>
						<input type="text" placeholder="Descripcion" id="desc" name="desc" class="form-control">
					</div>

					<div class="form-group">
						<label for="departamento">Seccion</label>
						<select class="form-control" name="seccion" id="seccion">
							<option value="0">...</option>
							<?php 
								foreach($seccion as $sec){
							?>
                				<option value="<?php echo $sec['idseccion']; ?>"><?php echo $sec['desc_seccion']; ?></option>
            				<?php 
            					}
            				?>
						</select>
					</div>

					<div class="form-group">
						<label for="marca">Marca</label>
						<input type="text" placeholder="Marca" id="marca" name="marca" class="form-control">
					</div>

					<div class="form-group">
						<label for="modelo">Modelo</label>
						<input type="text" placeholder="Modelo" id="modelo" name="modelo" class="form-control">
					</div>

					<div class="form-group">
						<label for="serial">Serial</label>
						<input type="text" placeholder="Serial" id="serial" name="serial" class="form-control">
					</div>
					
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
				</form>
				
				
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var codigo = $("#codigo").val();
				var desc = $("#desc").val();
				var seccion = $("#seccion").val();
				var marca = $("#marca").val();
				var modelo = $("#modelo").val();
				var serial = $("#serial").val();


			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('maquinas/crear_maquina'); ?>",
			    	data:{
			    		'codigo'	: 	codigo,
			    		'desc'		: 	desc,
			    		'seccion'	: 	seccion,
			    		'marca'		: 	marca,
			    		'modelo'	: 	modelo,
			    		'serial'	: 	serial
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Maquina creada Exitosamente!!!!!</div>";
							$("#codigo").val("");
							$("#desc").val("");
							$("#seccion").val("0");
							$("#marca").val("");
							$("#modelo").val("");
							$("#serial").val("");
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear esta maquina. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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