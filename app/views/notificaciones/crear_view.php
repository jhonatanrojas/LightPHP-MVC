<div class=" container-fluid  mt-5">
  <div id="wizard1" class="card">
  <form action="post" class="form-guardar">
    <div class="card-header">
      <h3>Datos de la notificación: </h3>
    </div>
    <div class="card-body">

      <div class=" row ">

        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Seleccionar bases</label>
            <select id="seleccion_bases" class="form-control">
              <option value="1">Seleccionar Todas</option>
              <option value="2" selected>Agregar Bases</option>
            </select>
          </div>
        </div>


        <div class="col-6">
          <div class="form-group">
            <label class="form-label">Numero de bases</label>
            <input type="text" name="nro_bases" required id="nro_bases" class="form-control" placeholder="agregue numeros de bases separadas por , 1234,456,">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Clientes version</label>
            <select class="form-control" readonly id="id_version">
              <option value="8" <?php echo isset($notificacion)  && $notificacion['id_version_base'] == 8 ? 'selected' :  '' ?>>Dora</option>
              <option value="1" <?php echo isset($notificacion)  && $notificacion['id_version_base'] == 1 ? 'selected' :  '' ?>>Practisis</option>

            </select>
          </div>
        </div>


        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Clientes Pais</label>
            <select class="form-control" readonly id="pais" name="pais">
              <option value="-1" <?php echo isset($notificacion)  && $notificacion['id_pais'] == -1 ? 'selected' :  '' ?>>Todos</option>

              <option value="1" <?php echo isset($notificacion)  && $notificacion['id_pais'] == 1 ? 'selected' :  '' ?>>Ecuador</option>
              <option value="27" <?php echo isset($notificacion)  && $notificacion['id_pais'] == 27 ? 'selected' :  '' ?>>Peru</option>

            </select>
          </div>
        </div>





      </div>

      <hr>
      <h3>Datos de la notificacion</h3>
      <div class="col-12">

        <div class="form-group">
          <label class="form-label">Titulo</label>
          <input type="text" name="titulo" required id="titulo" class="form-control" placeholder="Titulo de la notificacion">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Contenido</label>
        <textarea id="summernote" name="editordata" required>
    <?php echo isset($notificacion) ? $notificacion['cuerpo'] : '' ?>


    </textarea>
      </div>

      <div class="row justify-content-md-center">
        <div class="col-6">
          <button class="btn btn-primary btn-block btn-guardar"> Enviar Notificación</button>
        </div>

      </div>
    </div>


    </form>
  </div>
</div>