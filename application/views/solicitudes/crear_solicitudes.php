	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Solicitudes</a></li>
						<li class="active">Crear Solicitud</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">Solicitud de Mantenimiento</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-2">
									<label for="codigo">fecha</label>
									<div class='input-group date' id='datetimepicker1'>
						                <input type='text' class="form-control input-sm" name="fecdoc" id="fecdoc" value="<?php echo date("Y-m-d"); ?>" disabled/>
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
								<div class="form-group col-md-2 ui-widget">
									<label for="solicita">Solicitante</label>
									<input type="text" placeholder="Cedula" id="cedula" name="cedula" class="form-control input-sm">
								</div>
								<div class="form-group col-md-5">
									<label for="nombre">Nombre</label>
									<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-3">
									<label for="dpto">Departamento</label>
									<input type="text" placeholder="Departamento" id="dpto" name="dpto" class="form-control input-sm" disabled>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-6">
									<label for="servicio">Carácter del Servicio</label>
									<select class="form-control input-sm" name="servicio" id="servicio">
										<option value="0">...</option>
										<option value="IN">Inmediato</option>
										<option value="NI">No Inmediato</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="tipo">Tipo de Mantenimiento</label>
									<select class="form-control input-sm" name="tipo" id="tipo">
										<option value="0">...</option>
										<option value="P">Preventivo</option>
										<option value="C">Correctivo</option>
									</select>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-2 ui-widget">
									<label for="maquina">Maquina</label>
									<input type="text" placeholder="Maquina" id="maquina" name="maquina" class="form-control input-sm">
								</div>
								<div class="form-group col-md-6">
									<label for="nombre_maq">Descripcion Maquina</label>
									<input type="text" placeholder="Descripcion Maquina" id="descmaq" name="descmaq" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-2">
									<label for="seccion">Seccion</label>
									<input type="text" placeholder="Seccion" id="seccion" name="seccion" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-2">
									<label for="orden">Orden de Produccion</label>
									<input type="text" placeholder="Orden de Produccion" id="orden" name="orden" class="form-control input-sm">
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-12">
									<label for="detalle">Detalle de la Solicitud</label>
									<textarea class="form-control input-sm" rows="3" id="detalle" name="detalle"></textarea>
								</div>
					  		</div>
					  		

					  	</div>
					</div>

					<div align="center"><input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary"></div>
					
				</form>
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

				function completa_nombre_solicitante( nombre, departamento ) {
				    $("#nombre").val(nombre);
				    $("#dpto").val(departamento);
				}

				function completa_nombre_maquina( nombre, seccion ) {
				    $("#descmaq").val(nombre);
				    $("#seccion").val(seccion);
				}

			    $( "#cedula" ).autocomplete({
			      	source: "<?php echo base_url('empleados/get_empleados_criterio'); ?>",
			      	select: function( event, ui ) {
			        	completa_nombre_solicitante(ui.item.label, ui.item.dpto);
			      	}
			    });

			    $( "#maquina" ).autocomplete({
			      	source: "<?php echo base_url('maquinas/get_maquinas_criterio'); ?>",
			      	select: function( event, ui ) {
			        	completa_nombre_maquina(ui.item.label, ui.item.seccion);
			      	}
			    });    

				$('#aceptar').on('click',function(){
					var fecdoc = $("#fecdoc").val();
					var cedula = $("#cedula").val();
					var servicio = $("#servicio").val();
					var tipo = $("#tipo").val();
					var maquina = $("#maquina").val();
					var orden = $("#orden").val();
					var detalle = $("#detalle").val();

				    $.ajax({
				    	type:"POST",
				    	url:"<?php echo base_url('solicitudes/crear_solicitud'); ?>",
				    	data:{
				    		'fecdoc'	: 	fecdoc,
				    		'cedula'	: 	cedula,
				    		'servicio'	: 	servicio,
				    		'tipo'		: 	tipo,
				    		'maquina'	: 	maquina,
				    		'orden'		: 	orden,
				    		'detalle'	: 	detalle
				    	},
				    	success:function(data){
				    		console.log(data);
				    		var json = JSON.parse(data);
				    		//alert(json.mensaje);
							var html = "";
							
							
							if (json.mensaje > 0) {
								$('#myModal').modal('show');
								
								var id = json.mensaje;							
								var solicita = $("#cedula").val() + ' - ' + $("#nombre").val();
								var detalle = $("#detalle").val();
								//envio el correo de creacion de la solicitud
								$.ajax({
							    	type:"GET",
							    	url:"<?php echo base_url('enviarcorreos/send_correo_solicitud'); ?>",
							    	data:{
							    		'id'		: 	id,
							    		'solicita'	: 	solicita,
							    		'detalle'	: 	detalle
							    		
							    	},
							    	success:function(){
							    		
										var html = "";

										html += "<div class='alert alert-success' role='alert'>Gracias por utilizar la mesa de ayuda. Su solicitud ha sido enviada al area de mantenimiento</div>";
										$("#content").html(html);

							    	},
							    	error:function(jqXHR, textStatus, errorThrown){
							    		console.log('Error: '+ errorThrown);
							    	}
							    });

							    $("#cedula").val("");
								$("#nombre").val("");
								$("#servicio").val("0");
								$("#tipo").val("0");
								$("#maquina").val("");
								$("#descmaq").val("");
								$("#seccion").val("");
								$("#orden").val("");
								$("#detalle").val("");

							}else if(json.mensaje == false){
									html += "<div class='alert alert-danger' role='alert'>Ah ocurrido un error al intentar crear esta solicitud. Por favor revise la informacion o comuniquese con el administrador del sistema</div>";
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