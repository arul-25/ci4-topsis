        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
       <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Update Prodi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Prodi</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?=base_url('dashboard/prodi_update')?>" method="post" style="margin-top: 10px;">
                      <input type="hidden" name="id" value="<?=$id?>">
                      <input type="hidden" name="_method" value="PUT">
                      <div class="form-group row">
                        <label for="kd_prodi" class="col-sm-3 col-form-label">Kode Prodi</label>
                        <div class="col-sm-9">
                          <input type="text" name="kd_prodi" class="form-control" placeholder="Kode Prodi" value="<?php echo $data['kd_prodi']; ?>">
                          <input type="hidden" name="kd_prodi_old" value="<?php echo $data['kd_prodi']; ?>">
                          <span class="text-danger"><?php if(isset($validation['kd_prodi']) !='') echo $validation['kd_prodi'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nm_prodi" class="col-sm-3 col-form-label">Nama Prodi</label>
                        <div class="col-sm-9">
                          <input type="text" name="nm_prodi" class="form-control" placeholder="Nama Prodi" value="<?php echo $data['nm_prodi']; ?>">
                          <span class="text-danger"><?php if(isset($validation['nm_prodi']) !='') echo $validation['nm_prodi'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?=base_url('dashboard/prodi')?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
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
        <?= $this->endSection() ?>