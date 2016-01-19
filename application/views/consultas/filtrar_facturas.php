<section class="main container">
		<div class="row">
			<section class="posts col-md-12">
				<div class="miga-de-pan">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>">Inicio</a></li>
						<li><a href="#">Consultas</a></li>
						<li class="active">Facturas y Entregas</li>
					</ol>
				</div>
				
				<form name="form">
					<div class="panel panel-primary">
						<div class="panel-heading">Seleccione Filtros</div>
					  		<div class="panel-body">
						    	<div class="form-group col-md-3">
									<label for="estado">Estado</label>
									<select class="form-control input-sm" name="estadofac" id="estadofac">
										<option value="ALL">Todas</option>
										<option value="0">Por Despachar</option>
										<option value="P">Pendiente</option>
										<option value="OK">Ok</option>
									</select>
								</div>
								<div class="form-group col-md-3">
									<label for="tipodoc">Tipo Documento</label>
									<select class="form-control input-sm" name="tipodoc" id="tipodoc">
										<option value="0">Todos</option>
										<option value="F">Facturas</option>
										<option value="E">Entregas</option>
									</select>
								</div>
								<div class="form-group col-md-3">
									<label for="fecdocini">Fecha Doc. Inicial</label>
									<div class='input-group date' id='datetimepicker1'>
					                    <input type='text' class="form-control" name="fecini" id="fecini" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					            	</div>
								</div>
								<div class="form-group col-md-3">
									<label for="fecdocfin">Fecha Doc. Final</label>
									<div class='input-group date' id='datetimepicker2'>
					                    <input type='text' class="form-control" name="fecfin" id="fecfin" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					            	</div>
								</div>
								<div class="form-group col-md-3">
									<label for="fecenvio">Fecha Envio</label>
									<div class='input-group date' id='datetimepicker4'>
					                    <input type='text' class="form-control" name="fecenvio" id="fecenvio" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					            	</div>
								</div>
								<div class="col-md-3">
									<label for="transportador">Transportador</label>
									<select class="form-control input-sm" name="transportador" id="transportador">
										<option value="0">...</option>
										<?php 
											foreach($transportadores as $trp){
										?>
					                		<option value="<?php echo $trp['cod_transp']; ?>"><?php echo $trp['desc_transp']; ?></option>
					            		<?php 
					            			}
					            		?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="planilla">Planilla</label>
									<input type="text" placeholder="Planilla" id="planilla" name="planilla" class="form-control input-sm">
								</div>
					  	</div>
					</div>
					<div align="center"><input type="button" name="aceptar" id="aceptar" value="Aceptar" class="btn btn-primary" data-loading-text="Buscando..." autocomplete="off"></div>
					
				</form>
				<br>
				<div class="form-group" id="content"></div>
			</section>

		</div>
	</section>

	<script>
		$(document).ready(function(){           

			$('#aceptar').on('click',function(){
				
				var estado = $("#estadofac").val();
				var tipo = $("#tipodoc").val();
				var fecini = $("#fecini").val();
				var fecfin = $("#fecfin").val();
				var fecenvio = $("#fecenvio").val();
				var transp = $("#transportador").val();
				var planilla = $("#planilla").val();
				
				var html = "";
				var reg = 0;

				var $btn = $(this).button('loading');

				    $.ajax({
				    	type:"POST",
				    	url:"<?php echo base_url('consultas/filtrar_facturas'); ?>",
				    	data:{
				    		'estado'	: 	estado,
				    		'tipo'		: 	tipo,
				    		'fecini'	: 	fecini,
				    		'fecfin'	: 	fecfin,
				    		'fecenvio'	: 	fecenvio,
				    		'transp'	: 	transp,
				    		'planilla'	: 	planilla
				    	},
				    	success:function(data){
				    		console.log(data);
				    		var json = JSON.parse(data);
				    		//alert(json.mensaje);
							
							html += "<div><a href='javascript:void(0);' id='excel' title='Exportar a Excel'><img src='<?php echo base_url(); ?>assets/img/excel.png' width='20px' height='20px' /></a></div>";
							html += "<table class='table table-striped table-condensed table-hover' id='resultados'>";
							html += "<thead>";
							html += "<tr>";
							html += "<th>#</th>";
							html += "<th>Documento</th>";
							html += "<th>Cliente</th>";
							html += "<th>Item</th>";
							html += "<th>Descripcion</th>";
							html += "<th>Cantidad</th>";
							html += "<th>Ciudad</th>";
							html += "<th>Asesor</th>";
							html += "<th>Estado</th>";
							html += "</tr>";
							html += "</thead>";
						
							for(datos in json){
								reg = reg + 1;

								html += "<tr>";
								html +=	"<td>" + reg + "</td>";
								html +=	"<td><a href='<?php echo base_url('gestion/form_editar/" + json[datos].docnum  + "'); ?>'>" + json[datos].docnum + "</a></td>";
								html +=	"<td>" + json[datos].cardname + "</td>";
								html +=	"<td>" + json[datos].itemcode + "</td>";
								html +=	"<td>" + json[datos].itemdesc + "</td>";
								html +=	"<td align='right'>" + number_format(json[datos].cantidad_real,2) + "</td>";
								html +=	"<td>" + json[datos].city + "</td>";
								html +=	"<td>" + json[datos].slpname + "</td>";
								html +=	"<td>" + json[datos].estado_factura + "</td>";
								html += "</tr>";
						
							}
						
							html += "</table>";

							$("#content").html(html);
							$btn.button('reset');

				    	},
				    	error:function(jqXHR, textStatus, errorThrown){
				    		console.log('Error: '+ errorThrown);
				    	}
				    });
				
			});

			$(document).on('click','#excel',function(){
				$("#resultados").table2excel({
				    exclude: ".noExl",
				    name: "Excel Document Name"
				}); 
			});				
				
		});
	</script>