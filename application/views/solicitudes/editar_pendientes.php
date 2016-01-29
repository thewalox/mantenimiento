	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Pendientes</a></li>
						<li class="active">Editar Pendiente</li>
					</ol>
				</div>
				<?php
				if (!empty($pendiente)) {
				?>
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							Solicitud de Mantenimiento # <?php echo $pendiente->idsolicitud; ?>
						</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-12">
									<label for="pendiente">Tarea Pendiente</label>
									<textarea class="form-control input-sm" rows="3" id="pendiente" name="pendiente" disabled><?php echo $pendiente->pendiente; ?></textarea>
								</div>
					  		</div>
					  	</div>
					</div>

					<div align="center">
						<input type="button" name="aceptar" id="aceptar" value="Dar por Cumplido" class="btn btn-primary">
						<input type="button" name="cancelar" id="cancelar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'solicitudes/form_buscar_tareas'; ?>';">
						<input type="hidden" name="id" id="id" value="<?php echo $pendiente->idsolicitud; ?>">
					</div>
					
				</form>
				<?php
				}else{
				?>	
					<div class='alert alert-danger text-center' role='alert'>No existe tarea pendiente para esta solicitud o ya se encuentra en estado CUMPLIDA.</div>
				<?php
				}
				?>
				<div class="form-group" id="content2"></div>

				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Mensaje</h4>
				      </div>
				      <div class="modal-body">
				        Solicitud de Mantenimiento creada correctamente
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>

			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){  

			$('#aceptar').on('click',function(){

				if (confirm("Esta a punto de dar por cumplido a esta tarea. Su estado cambiará a CUMPLIDA. Desea continuar?")){ 
					var id = $("#id").val();

				    $.ajax({
				    	type:"GET",
				    	url:"<?php echo base_url('solicitudes/cerrar_pendiente'); ?>",
				    	data:{
				    		'id'	: 	id
				    	},
				    	success:function(data){
				    		console.log(data);
				    		var json = JSON.parse(data);
				    		//alert(json.mensaje);
							var html = "";
							
							
							if (json.mensaje == true) {
								html += "<div class='alert alert-success' role='alert'>Tarea Cumplida!!!!!</div>";
								$("#tiposol").attr('disabled', 'disabled');
								$("#diagnostico").attr('disabled', 'disabled');
								$("#solucion").attr('disabled', 'disabled');
								$("#tecnico").attr('disabled', 'disabled');
								$("#pendiente").attr('disabled', 'disabled');
							}else if(json.mensaje == false){
									html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar dar por cumplida esta tarea. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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