	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Maquinas</a></li>
						<li class="active">Editar Maquinas</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					
					<div class="form-group">
						<label for="codigo">Codigo</label>
						<input type="text" placeholder="Codigo" id="codigo" name="codigo" value="<?php echo $maquina->idmaquina; ?>" class="form-control" disabled>
					</div>
					
					<div class="form-group">
						<label for="descripcion">Descripcion</label>
						<input type="text" placeholder="Descripcion" id="desc" name="desc" value="<?php echo $maquina->desc_maquina; ?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="departamento">Seccion</label>
						<select class="form-control" name="seccion" id="seccion">
							<option value="0">...</option>
							<?php 
								foreach($seccion as $sec){
							?>
                				<option value="<?php echo $sec['idseccion']; ?>" <?php if($sec["idseccion"] == $maquina->idseccion){ ?> selected="selected" <?php } ?>><?php echo $sec['desc_seccion']; ?></option>
            				<?php 
            					}
            				?>
						</select>
					</div>
										
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					<input type="button" name="regresar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'Maquinas/form_buscar'; ?>';">

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

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('maquinas/editar_maquina'); ?>",
			    	data:{
			    		'codigo'	: 	codigo,
			    		'desc'		: 	desc,
			    		'seccion'	: 	seccion
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Maquina Modificada Exitosamente!!!!!</div>";
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar modificar esta maquina. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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