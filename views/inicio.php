<div class=" container-fluid  mt-5">
<style>
div::-webkit-scrollbar
{
height:7px;

}
div::-webkit-scrollbar-track
{
    border-radius: 10px;

    webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
div::-webkit-scrollbar-thumb
{
    background-color: a6c53b;


    webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}
div::-webkit-scrollbar {
    width: 1em;
    height:10px;
}
 
div::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
}
 
div::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}
</style>


<div class="card">
    <div class="card-header d-flex  justify-content-between">
        <h3 class="card-title">Campañas de E-mail</h3>
        <div class="acciones">
            <a class="btn btn-primary" href="<?php echo BASE_URL ?>?url=Inicio/new_campaign">Crear Campaña </a>
        </div>
    </div>
    <div class="card-body">
        <div class="panel panel-primary">
            <div class="tab-menu-heading">
                <div class="tabs-menu">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs panel-secondary">
                        <li><a href="#tab9" class="active" data-bs-toggle="tab"><span><i class="fa fa-envelope me-1"></i></span>Todos</a></li>
                        <li><a href="#tab10" data-bs-toggle="tab"><span><i class="fa fa-envelope-o me-1"></i></span>Borrador</a></li>
                        <li><a href="#tab11" data-bs-toggle="tab"><span><i class=" fe fe-bell  me-1"></i></span>Programados</a></li>
                        <li><a href="#enviados" data-bs-toggle="tab"><span><i class=" fa fa-envelope-open-o me-1 e-1"></i></span>Enviados</a></li>
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
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                                <th>Nombre</th>
                                                <th>Version</th>
                                                <th>Asunto</th>
                                                <th>Total a enviar</th>
                                                <th>Programados</th>
                                                <th> enviados</th>
                                                <th>Fecha </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($campanas as $key => $value) : ?>

                                                <?php
                                                $btn_estado = '   <span class="dot-label bg-warning my-auto"></span>';
                                                if ($value['estado'] == 1) {
                                                    $btn_estado = '  <span class="dot-label bg-primary my-auto"></span>';
                                                } else if ($value['estado'] == 2) {
                                                    $btn_estado = '  <span class="dot-label   bg-info y-auto"></span>';
                                                } else if ($value['estado'] == 3) {
                                                    $btn_estado = '  <span class="dot-label bg-success m my-auto"></span>';
                                                }


                                                ?>
                                                <tr>


                                                    <th>
                                                            
                                              
                                                            <button class="btn btn-sm btn-secondary btn-pruebas" data-id_campana="<?php echo $value['id'] ?>">Enviar prueba</button>


                                                     
                                                        <?php if ($value['estado'] == 2) : ?>
                                                            <button class="btn btn-sm  btn-warning btn-pausar" data-id_campana="<?php echo $value['id'] ?>">Pausar</button>
                                                        <?php elseif ($value['estado'] == 4) : ?>
                                                            <button class="btn btn-sm btn-info btn-programar" data-id_campana="<?php echo $value['id'] ?>">Programar</button>

                                                        <?php elseif ($value['estado'] == 1) : ?>
                                                            <button class="btn btn-sm  btn-info btn-programar" data-id_campana="<?php echo $value['id'] ?>">Programar</button>

                                                        <?php endif ?>
                                                        <a class="btn btn-sm btn-primary" data-id_campana="<?php echo $value['id'] ?>"
                                                        href="<?php echo BASE_URL?>?url=Inicio/editar/<?php echo $value['id'] ?>"
                            
                                                        
                                                        >Editar</a>
                                                        <button class="btn btn-sm btn-success btn-copia" data-id_campana="<?php echo $value['id'] ?>"
                                                        data-nombre="<?php echo $value['nombre'] ?>"
                                                        data-asunto="<?php echo $value['asunto'] ?>"
                                                        >Reenviar</button>
                                                        <?php if ($value['estado'] == 1) : ?>
                                                        <button class="btn btn-sm  btn-danger btn-elimimar" data-id_campana="<?php echo $value['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        <?php endif ?>
                                                    </th>
                                                    <td>

                                                        <?php
                                                        echo    $btn_estado;

                                                        echo $value['estatus'] ?>
                                                    </td>
                                                    <td> <?php echo $value['nombre'] ?></td>
                                                    <td> <?php echo $version[$value['id_version_base']] ?> - <?php echo $value['id_pais']== -1 ? 'Todos' : $pais[$value['id_pais']] ?> </td>
                                                    <td> <?php echo $value['asunto'] ?></td>

                                                    <td> <?php echo $value['total_envios'] ?></td>
                                                    <td> <?php echo $email_masivos->total_c_programados($value['id']) ?></td>
                                                    <td> <?php echo $email_masivos->total_c_enviados($value['id']) ?></td>

                                                    <?php if ($value['estado'] == 1) : ?>
                                                        <td>##/##/##</td>
                                                    <?php else : ?>
                                                        <td> <?php echo $value['fecha_envio'] ?></td>
                                                    <?php endif ?>
                                                </tr>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab10">
                    <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                                <th>Nombre</th>
                                                <th>Version</th>
                                                <th>Asunto</th>
                                                <th>Total a enviar</th>
                                                <th>Programados</th>
                                                <th> enviados</th>
                                                <th>Fecha </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($borradores as $key => $value) : ?>

                                                <?php
                                                $btn_estado = '   <span class="dot-label bg-warning my-auto"></span>';
                                                if ($value['estado'] == 1) {
                                                    $btn_estado = '  <span class="dot-label bg-primary my-auto"></span>';
                                                } else if ($value['estado'] == 2) {
                                                    $btn_estado = '  <span class="dot-label   bg-info y-auto"></span>';
                                                } else if ($value['estado'] == 3) {
                                                    $btn_estado = '  <span class="dot-label bg-success m my-auto"></span>';
                                                }


                                                ?>
                                                <tr>


                                                    <th>
                                                    <?php if ($value['estado'] == 1) : ?>
                                                            <button class="btn  btn-sm  btn-secondary btn-pruebas" data-id_campana="<?php echo $value['id'] ?>">Enviar prueba</button>
                                                            <?php endif ?>
                                                        <?php if ($value['estado'] == 2) : ?>
                                                            <button class="btn  btn-sm  btn-warning btn-pausar" data-id_campana="<?php echo $value['id'] ?>">Pausar</button>
                                                        <?php elseif ($value['estado'] == 4) : ?>
                                                            <button class="btn btn-warning btn-continuar" data-id_campana="<?php echo $value['id'] ?>">Continuar </button>

                                                        <?php elseif ($value['estado'] == 1) : ?>
                                                            <button class="btn btn-sm  btn-info btn-programar" data-id_campana="<?php echo $value['id'] ?>">Programar</button>

                                                        <?php endif ?>
                                                        <a class="btn btn-primary" data-id_campana="<?php echo $value['id'] ?>"
                                                        href="<?php echo BASE_URL?>?url=Inicio/editar/<?php echo $value['id'] ?>"
                            
                                                        
                                                        >Editar</a>                                                        <button class="btn btn-success btn-copia" data-id_campana="<?php echo $value['id'] ?>"
                                                        data-nombre="<?php echo $value['nombre'] ?>"
                                                        data-asunto="<?php echo $value['asunto'] ?>"
                                                        >Reenviar</button>
                                                    </th>
                                                    <td>

                                                        <?php
                                                        echo    $btn_estado;

                                                        echo $value['estatus'] ?>
                                                    </td>
                                                    <td> <?php echo $value['nombre'] ?></td>
                                                    <td> <?php echo $version[$value['id_version_base']] ?> - <?php echo $value['id_pais']== -1 ? 'Todos' : $pais[$value['id_pais']] ?> </td>
                                                    <td> <?php echo $value['asunto'] ?></td>

                                                    <td> <?php echo $value['total_envios'] ?></td>
                                                    <td> <?php echo $email_masivos->total_c_programados($value['id']) ?></td>
                                                    <td> <?php echo $email_masivos->total_c_enviados($value['id']) ?></td>

                                                    <?php if ($value['estado'] == 1) : ?>
                                                        <td>##/##/##</td>
                                                    <?php else : ?>
                                                        <td> <?php echo $value['fecha_envio'] ?></td>
                                                    <?php endif ?>
                                                </tr>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>

                    </div>
                    <div class="tab-pane" id="tab11">
                    <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                                <th>Nombre</th>
                                                <th>Version</th>
                                                <th>Asunto</th>
                                                <th>Total a enviar</th>
                                                <th>Programados</th>
                                                <th> enviados</th>
                                                <th>Fecha </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($programados as $key => $value) : ?>

                                                <?php
                                                $btn_estado = '   <span class="dot-label bg-warning my-auto"></span>';
                                                if ($value['estado'] == 1) {
                                                    $btn_estado = '  <span class="dot-label bg-primary my-auto"></span>';
                                                } else if ($value['estado'] == 2) {
                                                    $btn_estado = '  <span class="dot-label   bg-info y-auto"></span>';
                                                } else if ($value['estado'] == 3) {
                                                    $btn_estado = '  <span class="dot-label bg-success m my-auto"></span>';
                                                }


                                                ?>
                                                <tr>


                                                    <th>
                                                    <?php if ($value['estado'] == 1) : ?>
                                                            <button class="btn btn-sm  btn-secondary btn-pruebas" data-id_campana="<?php echo $value['id'] ?>">Enviar prueba</button>
                                                            <?php endif ?>
                                                        <?php if ($value['estado'] == 2) : ?>
                                                            <button class="btn btn-sm btn-secondary btn-pruebas" data-id_campana="<?php echo $value['id'] ?>">Enviar prueba</button>

                                                            <button class="btn btn-sm  btn-warning btn-pausar" data-id_campana="<?php echo $value['id'] ?>">Pausar</button>
                                                        <?php elseif ($value['estado'] == 4) : ?>
                                                            <button class="btn btn-sm  btn-warning btn-continuar" data-id_campana="<?php echo $value['id'] ?>">Continuar </button>

                                                        <?php elseif ($value['estado'] == 1) : ?>
                                                            <button class="btn btn-sm  btn-info btn-programar" data-id_campana="<?php echo $value['id'] ?>">Programar</button>

                                                        <?php endif ?>
                                                        <a class="btn btn-primary" data-id_campana="<?php echo $value['id'] ?>"
                                                        href="<?php echo BASE_URL?>?url=Inicio/editar/<?php echo $value['id'] ?>"
                            
                                                        
                                                        >Editar</a>                                                        <button class="btn btn-success btn-copia" data-id_campana="<?php echo $value['id'] ?>"
                                                        data-nombre="<?php echo $value['nombre'] ?>"
                                                        data-asunto="<?php echo $value['asunto'] ?>"
                                                        >Reenviar</button>                                                    </th>
                                                    <td>

                                                        <?php
                                                        echo    $btn_estado;

                                                        echo $value['estatus'] ?>
                                                    </td>
                                                    <td> <?php echo $value['nombre'] ?></td>
                                                    <td> <?php echo $version[$value['id_version_base']] ?> - <?php echo $value['id_pais']== -1 ? 'Todos' : $pais[$value['id_pais']] ?> </td>
                                                    <td> <?php echo $value['asunto'] ?></td>

                                                    <td> <?php echo $value['total_envios'] ?></td>
                                                    <td> <?php echo $email_masivos->total_c_programados($value['id']) ?></td>
                                                    <td> <?php echo $email_masivos->total_c_enviados($value['id']) ?></td>

                                                    <?php if ($value['estado'] == 1) : ?>
                                                        <td>##/##/##</td>
                                                    <?php else : ?>
                                                        <td> <?php echo $value['fecha_envio'] ?></td>
                                                    <?php endif ?>
                                                </tr>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>

                    </div>

                 
                    <div class="tab-pane" id="enviados">
                    <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                                <th>Nombre</th>
                                                <th>Version</th>
                                                <th>Asunto</th>
                                                <th>Total a enviar</th>
                                                <th>Programados</th>
                                                <th> enviados</th>
                                                <th>Fecha </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($enviados as $key => $value) : ?>

                                                <?php
                                                $btn_estado = '   <span class="dot-label bg-warning my-auto"></span>';
                                                if ($value['estado'] == 1) {
                                                    $btn_estado = '  <span class="dot-label bg-primary my-auto"></span>';
                                                } else if ($value['estado'] == 2) {
                                                    $btn_estado = '  <span class="dot-label   bg-info y-auto"></span>';
                                                } else if ($value['estado'] == 3) {
                                                    $btn_estado = '  <span class="dot-label bg-success m my-auto"></span>';
                                                }


                                                ?>
                                                <tr>


                                                    <th>

                          
                                                            <?php if ($value['estado'] == 2) : ?>
                                                            <button class="btn btn-warning btn-pausar" data-id_campana="<?php echo $value['id'] ?>">Pausar</button>
                                                        <?php elseif ($value['estado'] == 4) : ?>
                                                            <button class="btn btn-warning btn-continuar" data-id_campana="<?php echo $value['id'] ?>">Continuar </button>


                                                            
                                                        <?php elseif ($value['estado'] == 1) : ?>
                                                            <button class="btn btn-sm   btn-info btn-programar" data-id_campana="<?php echo $value['id'] ?>">Programar</button>

                                                        <?php endif ?>
                                                        <a class="btn  btn-sm btn-primary" data-id_campana="<?php echo $value['id'] ?>"
                                                        href="<?php echo BASE_URL?>?url=Inicio/editar/<?php echo $value['id'] ?>"
                            
                                                        
                                                        >Editar</a> 
                                                         <button class="btn btn-success btn-copia" data-id_campana="<?php echo $value['id'] ?>"
                                                        data-nombre="<?php echo $value['nombre'] ?>"
                                                        data-asunto="<?php echo $value['asunto'] ?>"
                                                        >Reenviar</button>                                                    </th>
                                                    <td>

                                                        <?php
                                                        echo    $btn_estado;

                                                        echo $value['estatus'] ?>
                                                    </td>
                                                    <td> <?php echo $value['nombre'] ?></td>
                                                    <td> <?php echo $version[$value['id_version_base']] ?> - <?php echo $value['id_pais']== -1 ? 'Todos' : $pais[$value['id_pais']] ?> </td>
                                                    <td> <?php echo $value['asunto'] ?></td>

                                                    <td> <?php echo $value['total_envios'] ?></td>
                                                    <td> <?php echo $email_masivos->total_c_programados($value['id']) ?></td>
                                                    <td> <?php echo $email_masivos->total_c_enviados($value['id']) ?></td>

                                                    <?php if ($value['estado'] == 1) : ?>
                                                        <td>##/##/##</td>
                                                    <?php else : ?>
                                                        <td> <?php echo $value['fecha_envio'] ?></td>
                                                    <?php endif ?>
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
<input type="hidden" name="id" id="id_campana" value="0">


<!-- Modal copia -->
<div class="modal fade" id="modal_copia" tabindex="-1" role="dialog" aria-labelledby="moda_programar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reenviar campaña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="" id="nombre_edit" class="form-control">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                        <label class="form-label">Asunto</label>
                        <input type="text" name="" id="asunto_edit" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                        <label class="form-label">Fecha de envio</label>
                        <input type="date" name="" id="fecha_reenvio" class="form-control" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" 
                                onclick=" $('#modal_copia').modal('hide')"
                class="btn btn-secondary btn-cerrar-modal" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-guardar-copia">Reenviar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal  programar-->
<div class="modal fade" id="moda_programar" tabindex="-1" role="dialog" aria-labelledby="moda_programar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Programar Fecha de envio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="wd-200 mg-b-30">
                    <label for="">Fecha de envio</label>
                    <div class="input-group" id="">
                        <div class="input-group-text">
                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                        </div><input class="form-control  fc-datepicker " placeholder="DD/MM/YYYY" type="text" id="fecha_envio">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-cerrar-modal" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-guardar-fecha">Guardar</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal  campana-->
<div class="modal fade" id="modal_pruebas" tabindex="-1" role="dialog" aria-labelledby="moda_programar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hacer una prueba de envio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="wd-200 mg-b-30">
                    <label for="">Ingrese su correo</label>
                    <div class="input-group" id="">
                        <div class="input-group-text">
                            <i class="fa fa-mail tx-16 lh-0 op-6"></i>
                        </div>
                        <input class="form-control   " placeholder="tucorreo@gmail.com" type="text" id="nombre_correo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"            onclick=" $('#modal_pruebas').modal('hide')" class="btn btn-secondary btn-cerrar-modal" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-enviar-pruebas">Enviar</button>

            </div>
        </div>
    </div>
</div>