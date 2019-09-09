      <div class="content">
        <div class="container-fluid">
                  <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
              <div class="page-categories">

                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#link100" role="tablist">
                          <i class="material-icons">add_circle</i> Agregar Nueva
                        </a>
                      </li>
                    <?php foreach($areas as $a){ ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link<?= $a['id_area']?>" role="tablist">
                          <i class="material-icons"><?= $a['icono']?></i> <?= $a['area']?>
                        </a>
                    </li>                                     
                    <?php }?>
                </ul>
                <div class="tab-content tab-space tab-subcategories">
                    <div class="tab-pane active" id="link100">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Agregar Nueva Cartera al Sistema</h4>
                            <p class="card-category">
                              <?php  ?>
                            </p>
                          </div>
                          <div class="card-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                  <div class="card ">
                                    <div class="card-header card-header-warning card-header-icon">
                                      <div class="card-icon">
                                        <i class="material-icons">add</i>
                                      </div>
                                      <h4 class="card-title"></h4>
                                    </div>
                                    <div class="card-body ">
                                     <?= form_open('mantenedores/agregar_cartera_area'); ?>
                                      <form method="#" action="#">
                                        <div class="form-group">
                                            <div class="col-lg-5 col-md-6 col-sm-3">
                                              <select class="selectpicker" data-style="select-with-transition" multiple title="Area" data-size="7" name="area">
                                                <?php foreach($areas as $a){ ?>
                                                     <option value="<?= $a['id_area'] ?>"><?= $a['area'] ?> </option>                                                        
                                                <?php }?>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-5 col-md-6 col-sm-3">
                                              <select class="selectpicker" data-style="select-with-transition" multiple title="Cartera" data-size="7" name="cartera">
                                                <?php foreach($carteras_serbanc as $a){ ?>
                                                     <option value="<?= $a['IDCARTERA'] ?>"><?= $a['NOMBRE'] ?> </option>                                                        
                                                <?php }?>
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                      <button type="submit" class="btn btn-fill btn-warning">Crear</button>
                                    </div>
                                    
                                      </form>
                                  </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php foreach($areas as $a){?>
                  <div class="tab-pane " id="link<?= $a['id_area']?>">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Carteras <?=$a['area'] ?></h4>

                      </div>
                      <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="card">
                                <div class="card-body">
                                  <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                      <thead>
                                        <tr>
                                           <th>ID</th>
                                          <th>Area</th>
                                          <th>Nombre</th>
                                          <th>Codigo</th>
                                          <th>Hora Proceso</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                      </thead>
                                      <tfoot>
                                        <th>ID</th>
                                          <th>Area</th>
                                          <th>Nombre</th>
                                          <th>Codigo</th>
                                          <th>Hora Proceso</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                      </tfoot>
                                      <tbody>
                                      
                                      <?php if(!empty($carteras)){ foreach($carteras as $t){
                                            if($t['area'] == $a['area']){?>
                                        <tr>
                                          <td><?=$t['IDCARTERA']?></td>
                                          <td><?=$t['area']?></td>
                                          <td><?=$t['NOMBRE']?></td>
                                          <td><?=$t['CODIGO']?></td>
                                          <td></td>                          
                                          <td class="text-right">
                                            <a href="#" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">favorite</i></a>
                                            <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                          </td>
                                        </tr>
                                       <?php } } }?>
                
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <!-- end content-->
                              </div>
                              <!--  end card  -->
                            </div>
                            <!-- end col-md-12 -->
                          </div>
          <!-- end row -->
                      </div>
                    </div>
                  </div>

                                    
                  <?php  }?>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      
      