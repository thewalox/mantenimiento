	<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Solicitudes</a></li>
						<li class="active">Ver Solicitud</li>
					</ol>
				</div>
				<?php
				if (!empty($solicitud)) {
				?>
				<form name="form">
					<div class="form-group" id="content">
					
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">Solicitud de Mantenimiento # <?php echo $solicitud->idsolicitud; ?></div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-2">
									<label for="codigo">fecha</label>
									<div class='input-group date' id='datetimepicker1'>
						                <input type='text' class="form-control" name="fecdoc" id="fecdoc" value="<?php echo $solicitud->fecha_solicitud; ?>" disabled/>
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
								<div class="form-group col-md-2 ui-widget">
									<label for="solicita">Solicitante</label>
									<input type="text" placeholder="Cedula" id="cedula" name="cedula" value="<?php echo $solicitud->idempleado; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-5">
									<label for="nombre">Nombre</label>
									<input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" value="<?php echo $solicitud->nombre; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-3">
									<label for="dpto">Departamento</label>
									<input type="text" placeholder="Departamento" id="dpto" name="dpto" value="<?php echo $solicitud->desc_departamento; ?>" class="form-control input-sm" disabled>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-4">
									<label for="servicio">Carácter del Servicio</label>
									<input type="text" placeholder="Servicio" id="servicio" name="servicio" value="<?php echo $solicitud->servicio; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-4">
									<label for="tipo">Tipo Mantenimiento</label>
									<input type="text" placeholder="Tipo Mantenimiento" id="tipo" name="tipo" value="<?php echo $solicitud->tipo_mtto; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-4">
									<label for="orden">Orden de Produccion</label>
									<input type="text" placeholder="Orden de Produccion" id="orden" name="orden" value="<?php echo $solicitud->orden_prod; ?>" class="form-control input-sm" disabled>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-2 ui-widget">
									<label for="maquina">Maquina</label>
									<input type="text" placeholder="Maquina" id="maquina" name="maquina" value="<?php echo $solicitud->idmaquina; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-6">
									<label for="nombre_maq">Descripcion Maquina</label>
									<input type="text" placeholder="Descripcion Maquina" id="descmaq" name="descmaq" value="<?php echo $solicitud->desc_maquina; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-2">
									<label for="seccion">Seccion</label>
									<input type="text" placeholder="Seccion" id="seccion" name="seccion" value="<?php echo $solicitud->desc_seccion; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-2">
									<label for="planta">Planta</label>
									<input type="text" placeholder="Planta" id="planta" name="planta" value="<?php echo $solicitud->desc_planta; ?>" class="form-control input-sm" disabled>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-12">
									<label for="detalle">Detalle de la Solicitud</label>
									<textarea class="form-control input-sm" rows="3" id="detalle" name="detalle" disabled><?php echo $solicitud->detalle; ?></textarea>
								</div>
					  		</div>
					  		

					  	</div>
					</div>

					<div class="panel panel-primary">
						<div class="panel-heading">Solucion de la Solicitud</div>
					  	<div class="panel-body">
					  		<div class="row">
					  			<div class="form-group col-md-3">
									<label for="codigo">fecha Solucion</label>
									<div class='input-group date' id='datetimepicker1'>
						                <input type='text' class="form-control" name="fecsol" id="fecsol" value="<?php echo $solicitud->fecha_solucion; ?>" disabled/>
						                <span class="input-group-addon">
						                <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
								</div>
					  			<div class="form-group col-md-4">
									<label for="tiposol">Tipo de Solucion</label>
									<input type="text" placeholder="Tipo de Solucion" id="tiposol" name="tiposol" value="<?php echo $solicitud->tipo_solucion; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-1">
									<label for="dias">Dias</label>
									<input type="text" placeholder="Dias" id="dias" name="dias" value="<?php echo $solicitud->dias; ?>" class="form-control input-sm" disabled>
								</div>
								<div class="form-group col-md-4">
									<label for="usuario">Usuario Solucion</label>
									<input type="text" placeholder="Usuario de Solucion" id="ususol" name="ususol" value="<?php echo $solicitud->usuario_solucion; ?>" class="form-control input-sm" disabled>
								</div>
					  		</div>

					  		<div class="row">
					  			<div class="form-group col-md-6">
									<label for="diagnostico">Diagnostico</label>
									<textarea class="form-control input-sm" rows="3" id="diagnostico" name="diagnostico" disabled><?php echo $solicitud->diagnostico; ?></textarea>
								</div>
								<div class="form-group col-md-6">
									<label for="solucion">Solucion</label>
									<textarea class="form-control input-sm" rows="3" id="solucion" name="solucion" disabled><?php echo $solicitud->solucion; ?></textarea>
								</div>
					  		</div>
					  	</div>
					</div>

					<div align="center">
						<input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary">
						<input type="button" name="cancelar" id="cancelar" value="Regresar" class="btn btn-success" onclick="javascript:location.href = '<?php echo base_url().'solicitudes/form_buscar'; ?>';">
						<input type="hidden" name="id" id="id" value="<?php echo $solicitud->idsolicitud; ?>">
						<input type="hidden" name="usuario" id="usuario" value="<?php echo $this->session->userdata('sess_name_user'); ?>">
					</div>
					
				</form>
				<?php
				}else{
				?>	
					<div class='alert alert-danger text-center' role='alert'>No existe solicitud con este criterio de busqueda.</div>
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