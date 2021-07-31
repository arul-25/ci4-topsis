        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
       <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Tambah Mahasiswa</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?=base_url('dashboard/mahasiswa_store')?>" method="post" style="margin-top: 10px;">
                      <div class="form-group row">
                        <label for="npm" class="col-sm-3 col-form-label">NPM</label>
                        <div class="col-sm-9">
                          <input type="text" name="npm" class="form-control" placeholder="NPM" value="<?php echo set_value('npm'); ?>">
                          <span class="text-danger"><?php if(isset($validation['npm']) !='') echo $validation['npm'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                          <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo set_value('nama'); ?>">
                          <span class="text-danger"><?php if(isset($validation['nama']) !='') echo $validation['nama'];?></span>
                        </div>
                      </div>
                      <fieldset class="form-group">
                        <div class="row">
                          <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin</legend>
                          <div class="col-sm-9">
                            <div class="custom-control custom-radio">
                              <input type="radio" id="customRadio1" name="jk" class="custom-control-input" value="Laki-Laki">
                              <label class="custom-control-label" for="customRadio1">Laki-Laki</label>
                            </div>
                            <div class="custom-control custom-radio">
                              <input type="radio" id="customRadio2" name="jk" class="custom-control-input" value="Perempuan">
                              <label class="custom-control-label" for="customRadio2">Perempuan</label>
                            </div>
                            <span class="text-danger"><?php if(isset($validation['jk']) !='') echo $validation['jk'];?></span>
                          </div>
                        </div>
                      </fieldset>
                      <div class="form-group row">
                        <label for="umur" class="col-sm-3 col-form-label">Umur</label>
                        <div class="col-sm-9">
                          <input type="number" name="umur" class="form-control" placeholder="Umur" value="<?php echo set_value('umur'); ?>">
                          <span class="text-danger"><?php if(isset($validation['umur']) !='') echo $validation['umur'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="asal_slta" class="col-sm-3 col-form-label">Asal SLTA</label>
                        <div class="col-sm-9">
                          <input type="text" name="asal_slta" class="form-control" placeholder="Asal SLTA" value="<?php echo set_value('asal_slta'); ?>">
                          <span class="text-danger"><?php if(isset($validation['asal_slta']) !='') echo $validation['asal_slta'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jurusan_slta" class="col-sm-3 col-form-label">Jurusan SLTA</label>
                        <div class="col-sm-9">
                          <input type="text" name="jurusan_slta" class="form-control" placeholder="Jurusan SLTA" value="<?php echo set_value('jurusan_slta'); ?>">
                          <span class="text-danger"><?php if(isset($validation['jurusan_slta']) !='') echo $validation['jurusan_slta'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="thn_lulus" class="col-sm-3 col-form-label">Tahun Lulus</label>
                        <div class="col-sm-9">
                          <input type="number" name="thn_lulus" class="form-control" placeholder="Tahun Lulus" value="<?php echo set_value('thn_lulus'); ?>">
                          <span class="text-danger"><?php if(isset($validation['thn_lulus']) !='') echo $validation['thn_lulus'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_prodi" class="col-sm-3 col-form-label">Prodi</label>
                        <div class="col-sm-9">
                            <select class="select2-single-placeholder form-control" name="id_prodi">
                              <option value="">Select</option>
                              <?php
                                    foreach($prodi as $rowp){
                                      echo '<option value="'.$rowp['id'].'">['.$rowp['kd_prodi'].'] '.$rowp['nm_prodi'].'</option>';
                                    }
                              ?>
                            </select>
                            <span class="text-danger"><?php if(isset($validation['id_prodi']) !='') echo $validation['id_prodi'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?=base_url('dashboard/mahasiswa')?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
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
              placeholder: "Pilih Prodi",
              allowClear: true
            }); 
          });
        </script>
        <?= $this->endSection() ?>