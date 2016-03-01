<div class="container">
	<div class="col-md-3">
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading text-center">Cambio de Contraseña</div>
			<div class="panel-body">
				<div class="form-group" id="content"></div>
				<div class="form-group col-md-12">
					<label for="clavenueva">Clave Nueva</label>
					<input type="password" placeholder="Digite Clave Nueva" id="clavenueva" name="clavenueva" class="form-control input-sm">
				</div>
				<div class="form-group col-md-12">
					<label for="clavenuevaconf">Confirme Clave Nueva</label>
					<input type="password" placeholder="Digite Confirmacion Clave Nueva" id="clavenuevaconf" name="clavenuevaconf" class="form-control input-sm">
				</div>
				<div align="center">
					<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
					<input type="button" name="cancelar" id="cancelar" value="Cancelar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'login/form_cambio_clave'; ?>';">
					<input type="hidden" name="usuario" id="usuario" value="<?php echo $this->session->userdata('sess_id_user');  ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
	</div>
</div>
	<script>
		$(document).ready(function(){  

			$('#aceptar').on('click',function(){

				if (confirm("Esta a punto de cambiar su clave. Desea continuar?")){ 
					var clavenueva = $("#clavenueva").val();
					var clavenuevaconf = $("#clavenuevaconf").val();
					var usuario = $("#usuario").val();

				    $.ajax({
				    	type:"POST",
				    	url:"<?php echo base_url('login/cambiar_clave'); ?>",
				    	data:{
				    		'clavenueva'		: 	clavenueva,
				    		'clavenuevaconf'	: 	clavenuevaconf,
				    		'usuario'			: 	usuario,
				    		'claveencrypt'		: 	calcMD5(clavenueva)
				    	},
				    	success:function(data){
				    		console.log(data);
				    		var json = JSON.parse(data);
				    		//alert(json.mensaje);
							var html = "";
							
							
							if (json.mensaje == true) {
								html += "<div class='alert alert-success' role='alert'>Clave actualizada exitosamente. Se recomienda volver a iniciar sesion.</div>";
								$("#clavenueva").val("");
								$("#clavenuevaconf").val("");
							}else if(json.mensaje == false){
									html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar actualizar la clave. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
							}else{
									html += "<div class='alert alert-danger' role='alert'>" + json.mensaje + "</div>";
							}
							

							$("#content").html(html);

				    	},
				    	error:function(jqXHR, textStatus, errorThrown){
				    		console.log('Error: '+ errorThrown);
				    	}
				    });
				}else{
					return false;
				}
			});
				
		});
	</script>