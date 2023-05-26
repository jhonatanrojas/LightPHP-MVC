<div class="container">
<div class="card">
    <div class="card-header d-flex  justify-content-between">
        <h3 class="card-title">Notificaciones</h3>
        <div class="acciones">
            <a class="btn btn-primary" href="<?php echo BASE_URL ?>?url=Notificaciones/crear">Crear notificacición </a>
        </div>
    </div>
    <div class="card-body">
        <div class="panel panel-primary">
            <div class="tab-menu-heading">
                <div class="tabs-menu">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs panel-secondary">
                        <li><a href="#tab9" class="active" data-bs-toggle="tab"><span><i class="fa fa-envelope me-1"></i></span>Enviadas</a></li>

                        <li><a href="#tab2" class="" data-bs-toggle="tab"><span><i class="fa fa-envelope me-1"></i></span>Automaticas</a></li>

                    </ul>
                
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">

                    <div class="tab-pane active" id="tab9">
                        <div class="card ">
                            <div class="card-header ">





                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                            <th> </th>
                                                <th>Titulo</th>
                                                <th>Cuerpo</th>
                                                <th>Fecha</th>
                                                <th>Total enviados</th>                                           
                                          
                                         
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($notificaciones as $key => $value) : ?>

                                                <?php
                                  
                                                ?>
                                                <tr>


                                                    <th>
                                                  
                                                    
                                                        <button class="btn btn-success btn-copia"  onclick="mostrar_notificacion(<?php echo $value['id'] ?>)"  data-id_notificacion="<?php echo $value['id'] ?>"
                                                   
                                                        >Ver detalle</button>
                                                    </th>
                                                  
                                                    <td> <?php echo $value['titulo'] ?></td>
                                                    <td> </td>
                                                    <td> <?php echo $value['creado'] ?></td>

                                                    <td> <?php echo $value['total'] ?></td>


                                                </tr>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="tab-pane active" id="tab2">
                        <div class="card ">
                            <div class="card-header ">





                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                            <th> </th>
                                                <th>Titulo</th>
                                                <th>Cuerpo</th>
                                                <th>Fecha</th>
                                                <th>Total enviados</th>                                           
                                          
                                         
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($automaticas as $key => $value) : ?>

                                                <?php
                                  
                                                ?>
                                                <tr>


                                                    <th>
                                                  
                                                    
                                                        <button class="btn btn-success btn-copia" onclick="mostrar_notificacion(<?php echo $value['id'] ?>)" data-id_notificacion="<?php echo $value['id'] ?>"
                                                   
                                                        >Ver detalle</button>
                                                    </th>
                                                  
                                                    <td> <?php echo $value['titulo'] ?></td>
                                                    <td> </td>
                                                    <td> <?php echo $value['creado'] ?></td>

                                                    <td>1</td>


                                                </tr>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
           
                 
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<div id="myModalNotificaciones"  tabindex="-1"  class="modal fade" role="dialog" data-backdrop='static' style='background-color:rgba(10,10,10,0.4); '>
			  <div class="modal-dialog modal-lg" role="document" data-backdrop='static'>

			    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
					<h4 class="modal-title" id="s_titulo_notificacion"></h4>
					</div>
					<div class="modal-body" style="  min-height: 500px;">
					<p id="s_cuerpo_notificacion"> </p>
					</div>
                    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" onclick="$('#myModalNotificaciones').modal('hide)" data-dismiss="modal">salir</button>
      </div>
				
				</div>

				</div>
			</div>