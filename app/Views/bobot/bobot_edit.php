        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Update Bobot</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Bobot</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-6">
                    <form action="<?= base_url('dashboard/bobot_update') ?>" method="post" style="margin-top: 10px;">
                      <input type="hidden" name="id" value="<?= $id ?>">
                      <input type="hidden" name="_method" value="PUT">
                      <div class="form-group row">
                        <label for="thn_akademik" class="col-sm-4 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-8">
                          <input type="number" name="thn_akademik" class="form-control" placeholder="Tahun Akademik" value="<?php echo $data['thn_akademik']; ?>">
                          <span class="text-danger"><?php if (isset($validation['thn_akademik']) != '') echo $validation['thn_akademik']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_persyaratan" class="col-sm-4 col-form-label">Persyaratan</label>
                        <div class="col-sm-8">
                          <select class="select2-single-placeholder form-control" name="id_persyaratan">
                            <option value="">Select</option>
                            <?php
                            foreach ($persyaratan as $rowp) {
                              if (in_array($rowp['id'], $id_bobot) && $data['id_persyaratan'] != $rowp['id']) continue;
                              echo '<option value="' . $rowp['id'] . '" ' . (($data['id_persyaratan'] == $rowp['id']) ? 'selected' : '') . '>[' . $rowp['kd_persyaratan'] . '] ' . $rowp['nm_persyaratan'] . '</option>';
                            }
                            ?>
                          </select>
                          <span class="text-danger"><?php if (isset($validation['id_persyaratan']) != '') echo $validation['id_persyaratan']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="bobot" class="col-sm-4 col-form-label">Bobot</label>
                        <div class="col-sm-8">
                          <select class="select2-single-placeholder2 form-control" name="bobot">
                            <option value="">Select</option>
                            <option value="5" <?php echo $data['bobot'] == 5 ? 'selected' : ''; ?>>5 - Sangat Layak</option>
                            <option value="4" <?php echo $data['bobot'] == 4 ? 'selected' : ''; ?>>4 - Lebih Layak</option>
                            <option value="3" <?php echo $data['bobot'] == 3 ? 'selected' : ''; ?>>3 - Layak</option>
                            <option value="2" <?php echo $data['bobot'] == 2 ? 'selected' : ''; ?>>2 - Cukup Layak</option>
                            <option value="1" <?php echo $data['bobot'] == 1 ? 'selected' : ''; ?>>1 - Tidak Layak</option>
                          </select>
                          <span class="text-danger"><?php if (isset($validation['bobot']) != '') echo $validation['bobot']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12" align="right">
                          <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?= base_url('dashboard/persyaratan') ?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
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
          $(document).ready(function() {
            $('.select2-single-placeholder').select2({
              placeholder: "Pilih Persyaratan",
              allowClear: true
            });
            $('.select2-single-placeholder2').select2({
              placeholder: "Pilih Bobot",
              allowClear: true
            });
          });
        </script>
        <?= $this->endSection() ?>