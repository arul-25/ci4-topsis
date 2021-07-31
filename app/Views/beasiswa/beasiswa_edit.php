        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
       <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Update Beasiswa</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Beasiswa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?=base_url('dashboard/beasiswa_update')?>" method="post" style="margin-top: 10px;">
                      <input type="hidden" name="id" value="<?=$id?>">
                      <input type="hidden" name="_method" value="PUT">
                      <div class="form-group row">
                        <label for="kd_beasiswa" class="col-sm-4 col-form-label">Kode Beasiswa</label>
                        <div class="col-sm-8">
                          <input type="text" name="kd_beasiswa" class="form-control" placeholder="Kode Beasiswa" value="<?php echo $data['kd_beasiswa']; ?>">
                          <input type="hidden" name="kd_beasiswa_old" value="<?php echo $data['kd_beasiswa']; ?>">
                          <span class="text-danger"><?php if(isset($validation['kd_beasiswa']) !='') echo $validation['kd_beasiswa'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nm_beasiswa" class="col-sm-4 col-form-label">Nama Beasiswa</label>
                        <div class="col-sm-8">
                          <input type="text" name="nm_beasiswa" class="form-control" placeholder="Nama Beasiswa" value="<?php echo $data['nm_beasiswa']; ?>">
                          <span class="text-danger"><?php if(isset($validation['nm_beasiswa']) !='') echo $validation['nm_beasiswa'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="sumber" class="col-sm-4 col-form-label">Sumber</label>
                        <div class="col-sm-8">
                          <input type="text" name="sumber" class="form-control" placeholder="Sumber" value="<?php echo $data['sumber']; ?>">
                          <span class="text-danger"><?php if(isset($validation['sumber']) !='') echo $validation['sumber'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                          <input type="text" name="jumlah" class="form-control" placeholder="Jumlah" value="<?php echo $data['jumlah']; ?>">
                          <span class="text-danger"><?php if(isset($validation['jumlah']) !='') echo $validation['jumlah'];?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?=base_url('dashboard/beasiswa')?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
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