	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Secciones</a></li>
						<li class="active">Editar Secciones</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					
					<div class="form-group">
						<label for="codigo">Codigo</label>
						<input type="text" placeholder="Codigo" id="codigo" name="codigo" value="<?php echo $seccion->idseccion; ?>" class="form-control" disabled>
					</div>
					
					<div class="form-group">
						<label for="descripcion">Descripcion</label>
						<input type="text" placeholder="Descripcion" id="desc" name="desc" value="<?php echo $seccion->desc_seccion; ?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="departamento">Planta</label>
						<select class="form-control" name="planta" id="planta">
							<option value="0">...</option>
							<?php 
								foreach($planta as $pl){
							?>
                				<option value="<?php echo $pl['idplanta']; ?>" <?php if($pl["idplanta"] == $seccion->idplanta){ ?> selected="selected" <?php } ?>><?php echo $pl['desc_planta']; ?></option>
            				<?php 
            					}
            				?>
						</select>
					</div>
										
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					<input type="button" name="regresar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'Secciones/form_buscar'; ?>';">

				</form>
				
				
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var codigo = $("#codigo").val();
				var desc = $("#desc").val();
				var planta = $("#planta").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('secciones/editar_seccion'); ?>",
			    	data:{
			    		'codigo'	: 	codigo,
			    		'desc'		: 	desc,
			    		'planta'	: 	planta
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Seccion Modificada Exitosamente!!!!!</div>";
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar modificar esta seccion. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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