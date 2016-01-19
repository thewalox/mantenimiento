	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Secciones</a></li>
						<li class="active">Crear Secciones</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content"></div>
					
					<div class="form-group">
						<label for="descripcion">Descripcion</label>
						<input type="text" placeholder="Descripcion" id="desc" name="desc" class="form-control">
					</div>

					<div class="form-group">
						<label for="departamento">Planta</label>
						<select class="form-control" name="planta" id="planta">
							<option value="0">...</option>
							<?php 
								foreach($planta as $pl){
							?>
                				<option value="<?php echo $pl['idplanta']; ?>"><?php echo $pl['desc_planta']; ?></option>
            				<?php 
            					}
            				?>
						</select>
					</div>
					
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
				</form>
				
				
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var desc = $("#desc").val();
				var planta = $("#planta").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('secciones/crear_seccion'); ?>",
			    	data:{
			    		'desc'		: 	desc,
			    		'planta'	: 	planta
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Seccion creada Exitosamente!!!!!</div>";
							$("#desc").val("");
							$("#planta").val("0");
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear esta seccion. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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