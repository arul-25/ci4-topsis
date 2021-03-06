        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Tambah Persyaratan</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Persyaratan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <div class="col-md-10">
                    <form action="<?= base_url('dashboard/persyaratan_store') ?>" method="post" style="margin-top: 10px;">
                      <div class="form-group row">
                        <label for="kd_persyaratan" class="col-sm-3 col-form-label">Kode Persyaratan</label>
                        <div class="col-sm-6">
                          <input type="text" name="kd_persyaratan" class="form-control" placeholder="Kode Persyaratan" value="<?php echo set_value('kd_persyaratan'); ?>">
                          <span class="text-danger"><?php if (isset($validation['kd_persyaratan']) != '') echo $validation['kd_persyaratan']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="id_beasiswa" class="col-sm-3 col-form-label">Beasiswa</label>
                        <div class="col-sm-6">
                          <select class="select2-single-placeholder form-control" name="id_beasiswa">
                            <option value="">Select</option>
                            <?php
                            foreach ($beasiswa as $rowb) {
                              echo '<option value="' . $rowb['id'] . '">[' . $rowb['kd_beasiswa'] . '] ' . $rowb['nm_beasiswa'] . '</option>';
                            }
                            ?>
                          </select>
                          <span class="text-danger"><?php if (isset($validation['id_beasiswa']) != '') echo $validation['id_beasiswa']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nm_persyaratan" class="col-sm-3 col-form-label">Nama Persyaratan</label>
                        <div class="col-sm-6">
                          <input type="text" name="nm_persyaratan" class="form-control" placeholder="Nama Persyaratan" value="<?php echo set_value('nm_persyaratan'); ?>">
                          <span class="text-danger"><?php if (isset($validation['nm_persyaratan']) != '') echo $validation['nm_persyaratan']; ?></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="type_persyaratan" class="col-sm-3 col-form-label">Type Persyaratan</label>
                        <div class="col-sm-6">
                          <select class="select3-single-placeholder form-control" id="type_persyaratan" name="type_persyaratan">
                            <option value="">Select</option>
                            <option value="jawaban">Jawaban</option>
                            <option value="pilihan">Pilihan</option>
                          </select>
                          <span class="text-danger"><?php if (isset($validation['type_persyaratan']) != '') echo $validation['type_persyaratan']; ?></span>
                        </div>
                      </div>

                      <div class="form-group button row">
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
              placeholder: "Pilih Beasiswa",
              allowClear: true
            });
            $('.select3-single-placeholder').select2({
              placeholder: "Pilih Tipe Persyaratan",
              allowClear: true
            });

            $('#type_persyaratan').on('change', function() {
              let type_persyaratan = $('#type_persyaratan').val();

              if (type_persyaratan != 'pilihan') {
                $('.form-type').remove();
              } else {
                let form = createFormType();
                $('form .button').before(form)
              }
            })

            $('form').on('click', '#hapus-item', function() {
              let item = $(this).parents('div.form-group');
              item.remove();

            })

            $('form').on('click', '#button-tambah', function() {
              $('.form-type').append(createInputPilihan());
            })

          });

          function createInputPilihan() {
            return `
              <div class="form-group row">
                <div class="col-sm-5">
                  <input type="text" name="nama_pilihan[]" class="form-control" placeholder="Nama Pilihan" required>
                  <span class="text-danger"></span>
                </div>
                <div class="col-sm-5">
                  <input type="number" name="nilai_pilihan[]" class="form-control" placeholder="Nilai Pilihan" required>
                  <span class="text-danger"></span>
                </div>
                <div class="col-sm-2 ">
                  <button class="mt-2" type="button" id="hapus-item" data-toggle="tooltip" data-placement="top" title="hapus"><i class="fas fa-trash-alt"></i></button>
                </div>
              </div>
            `
          }

          function createFormType() {
            return `
              <div class="form-type mt-5 mb-4">
                <button type="button" id="button-tambah" class="btn btn-outline-primary btn-sm mb-4">+ Tambah Type</button>
                <div class="form-group row">
                  <div class="col-sm-5">
                    <input type="text" name="nama_pilihan[]" class="form-control" placeholder="Nama Pilihan" required>
                    <span class="text-danger"></span>
                  </div>
                  <div class="col-sm-5">
                    <input type="number" name="nilai_pilihan[]" class="form-control" placeholder="Nilai Pilihan" required>
                    <span class="text-danger"></span>
                  </div>
                  <div class="col-sm-2 ">
                    <button class="mt-2" type="button" id="hapus-item" data-toggle="tooltip" data-placement="top" title="hapus"><i class="fas fa-trash-alt"></i></button>
                  </div>
                </div>
              </div>
            `
          }
        </script>

        <?= $this->endSection() ?>