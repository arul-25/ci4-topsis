        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
       <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Update Persyaratan</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Persyaratan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?=base_url('dashboard/persyaratan_update')?>" method="post" style="margin-top: 10px;">
                      <input type="hidden" name="id" value="<?=$id?>">
                      <input type="hidden" name="_method" value="PUT">
                      <div class="form-group row">
                        <label for="kd_persyaratan" class="col-sm-4 col-form-label">Kode Persyaratan</label>
                        <div class="col-sm-8">
                          <input type="text" name="kd_persyaratan" class="form-control" placeholder="Kode Persyaratan" value="<?php echo $data['kd_persyaratan']; ?>">
                          <input type="hidden" name="kd_persyaratan_old" value="<?php echo $data['kd_persyaratan']; ?>">
                          <span class="text-danger"><?php if(isset($validation['kd_persyaratan']) !='') echo $validation['kd_persyaratan'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nm_persyaratan" class="col-sm-4 col-form-label">Nama Persyaratan</label>
                        <div class="col-sm-8">
                          <input type="text" name="nm_persyaratan" class="form-control" placeholder="Nama Persyaratan" value="<?php echo $data['nm_persyaratan']; ?>">
                          <span class="text-danger"><?php if(isset($validation['nm_persyaratan']) !='') echo $validation['nm_persyaratan'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_beasiswa" class="col-sm-4 col-form-label">Beasiswa</label>
                        <div class="col-sm-8">
                            <select class="select2-single-placeholder form-control" name="id_beasiswa">
                              <option value="">Select</option>
                              <?php
                                    foreach($beasiswa as $rowb){
                                      echo '<option value="'.$rowb['id'].'" '.(($data['id_beasiswa'] == $rowb['id']) ? 'selected' : '').'>['.$rowb['kd_beasiswa'].'] '.$rowb['nm_beasiswa'].'</option>';
                                    }
                              ?>
                            </select>
                            <span class="text-danger"><?php if(isset($validation['id_beasiswa']) !='') echo $validation['id_beasiswa'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?=base_url('dashboard/persyaratan')?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
        <script>
          $(document).ready(function () {
            $('.select2-single-placeholder').select2({
              placeholder: "Pilih Beasiswa",
              allowClear: true
            }); 
          });
        </script>
        <?= $this->endSection() ?>