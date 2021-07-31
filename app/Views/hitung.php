        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
       <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Perhitungan SPK Topsis</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Perhitungan</a></li>
              <li class="breadcrumb-item active" aria-current="page">SPK Topsis</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?=base_url('dashboard/hitung')?>" method="post" style="margin-top: 10px;">
                      <div class="form-group row">
                        <label for="thn_akademik" class="col-sm-4 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-8">
                          <input type="number" name="thn_akademik" class="form-control" placeholder="Tahun Akademik" value="<?php echo isset($_POST['thn_akademik']) && $_POST['thn_akademik'] != '' ? $_POST['thn_akademik'] : date('Y') ; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_beasiswa" class="col-sm-4 col-form-label">Beasiswa</label>
                        <div class="col-sm-8">
                            <select class="select2-single-placeholder form-control" name="id_beasiswa">
                              <option value="">Select</option>
                              <?php
                                    foreach($beasiswa as $rowb){
                                      echo '<option value="'.$rowb['id'].'" '.((isset($_POST['id_beasiswa']) && $_POST['id_beasiswa'] == $rowb['id']) ? 'selected' : '').'>['.$rowb['kd_beasiswa'].'] '.$rowb['nm_beasiswa'].'</option>';
                                    }
                              ?>
                            </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_prodi" class="col-sm-4 col-form-label">Prodi</label>
                        <div class="col-sm-8">
                            <select class="select2-single-placeholder2 form-control" name="id_prodi">
                              <option value="">Select</option>
                              <?php
                                    foreach($prodi as $rowp){
                                      echo '<option value="'.$rowp['id'].'" '.((isset($_POST['id_beasiswa']) && $_POST['id_prodi'] == $rowb['id']) ? 'selected' : '').'>['.$rowp['kd_prodi'].'] '.$rowp['nm_prodi'].'</option>';
                                    }
                              ?>
                            </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-calculator"></i> Hitung</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="table-responsive p-3">
                  
                  <?php
                       if(isset($_POST['id_beasiswa']) && isset($_POST['id_prodi']) && isset($_POST['thn_akademik'])){
                          echo 'perhitungan berhasil  di generate, silakan lihat hasil seleksi';
                       }
                  ?>
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
            $('.select2-single-placeholder2').select2({
              placeholder: "Pilih Prodi",
              allowClear: true
            }); 
          });
        </script>
        <?= $this->endSection() ?>