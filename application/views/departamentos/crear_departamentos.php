	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Departamentos</a></li>
						<li class="active">Crear Departamentos</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					
					<div class="form-group">
						<label for="descripcion">Descripcion</label>
						<input type="text" placeholder="Descripcion" id="descripcion" name="descripcion" class="form-control">
					</div>
					
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
				</form>
				
				
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){

			$('#aceptar').on('click',function(){
				var descripcion = $("#descripcion").val();

			    $.ajax({
			    	type:"POST",
			    	url:"<?php echo base_url('departamentos/crear_departamento'); ?>",
			    	data:{
			    		'descripcion'	: 	descripcion
			    	},
			    	success:function(data){
			    		console.log(data);
			    		var json = JSON.parse(data);
			    		//alert(json.mensaje);
						var html = "";
						
						
						if (json.mensaje == 2) {
							html += "<div class='alert alert-success' role='alert'>Departamento creado Exitosamente!!!!!</div>";
							$("#descripcion").val("");
						}else if(json.mensaje == 3){
								html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear este departamento. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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