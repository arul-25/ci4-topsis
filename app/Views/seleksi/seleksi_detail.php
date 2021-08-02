        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Form Update Persyaratan Seleksi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Persyaratan Seleksi</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">

                <div class="table-responsive p-3">
                  <?php
                  $data_seleksi = $lib->getAllDataSeleksi(dekrip($id));
                  $id_mahasiswa = $data_seleksi->id_mahasiswa;
                  $data_mahasiswa = $lib->getAllDataMahasiswa($id_mahasiswa);
                  $data_prodi = $lib->getNameProdi($data_mahasiswa->id_prodi);
                  $id_seleksi = dekrip($id);
                  $bobots = [];
                  ?>
                  <div class="col-md-6">
                    <table style="margin-bottom: 50px;">
                      <tr>
                        <td>Tahun Akademik</td>
                        <td style="width: 30px;text-align: center;">:</td>
                        <td> <?= $data_seleksi->thn_akademik ?></td>
                      </tr>
                      <tr>
                        <td>Beasiswa</td>
                        <td style="width: 30px;text-align: center;">:</td>
                        <td> <?= $lib->getNameBeasiswa($data_seleksi->id_beasiswa) ?></td>
                      </tr>
                      <tr>
                        <td>NPM</td>
                        <td style="width: 30px;text-align: center;">:</td>
                        <td> <?= $data_mahasiswa->npm ?></td>
                      </tr>
                      <tr>
                        <td>Nama Mahasiswa</td>
                        <td style="width: 30px;text-align: center;">:</td>
                        <td> <?= $data_mahasiswa->nama ?></td>
                      </tr>
                      <tr>
                        <td>Prodi</td>
                        <td style="width: 30px;text-align: center;">:</td>
                        <td> <?= $data_prodi ?></td>
                      </tr>
                    </table>
                    <form action="<?= base_url('dashboard/seleksi_detail_update') ?>" method="post" style="margin-top: 10px;">
                      <input type="hidden" name="id" value="<?= $id ?>">
                      <input type="hidden" name="thn_akademik" value="<?= $data_seleksi->thn_akademik ?>">
                      <?php $dataPersyaratan = []; ?>
                      <?php foreach ($persyaratan as $rows) : ?>

                        <?php $jawaban = $lib->getJawaban($id_seleksi, $rows['id']); ?>

                        <?php $bobot = $BobotModel->where('id_persyaratan', $rows['id'])->findAll(); ?>
                        <?php $bobots[] = $bobot; ?>

                        <?php if ($rows['type_persyaratan'] == 'jawaban') : ?>
                          <div class="form-group row">
                            <input type="hidden" name="id_persyaratan[]" value="<?= $rows['id']; ?>">
                            <label for="jawaban" class="col-sm-5 col-form-label"><?= $rows['nm_persyaratan']; ?></label>
                            <div class="col-sm-7">
                              <input type="number" name="jawaban[]" class="form-control" placeholder="Jawaban" value="<?= $jawaban; ?>" required="required">
                              <span class="text-danger"><?= !$bobot ? "Bobot " . $rows['nm_persyaratan'] . " belum ada" : ''; ?></span>
                            </div>
                          </div>

                        <?php else : ?>
                          <div class="form-group row">
                            <input type="hidden" name="id_persyaratan[]" value="<?= $rows['id']; ?>">
                            <label for="jawaban" class="col-sm-5 col-form-label"><?= $rows['nm_persyaratan']; ?></label>
                            <div class="col-sm-7">
                              <select class="form-control <?= 'select' . $rows['id'] . '-single-placeholder'; ?>" id="type_persyaratan" name="jawaban[]" required>
                                <option value="">Pilih</option>

                                <?php foreach ($PilihanPersyaratanModel->where('id_persyaratan', $rows['id'])->findAll() as $dt) : ?>
                                  <option value="<?= $dt['nilai_pilihan']; ?>"><?= $dt['pilihan']; ?></option>
                                  <?php $dataPersyaratan[] = $dt; ?>
                                <?php endforeach; ?>
                              </select>
                              <span class="text-danger"><?= !$bobot ? "Bobot " . $rows['nm_persyaratan'] . " belum ada" : ''; ?></span>
                            </div>
                          </div>

                        <?php endif; ?>
                      <?php endforeach; ?>
                      <div class="form-group row">

                        <div class="col-sm-12" align="right">
                          <?php if ($dataPersyaratan) : ?>
                            <?php if (!$bobots) : ?>
                              <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                            <?php endif; ?>
                          <?php endif; ?>
                          <a href="<?= base_url('dashboard/seleksi') ?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-undo-alt"></i> Batal</a>
                        </div>
                        <?php if ($bobots) : ?>
                          <span class="text-danger mt-4">Ada Persyaratan yang belum mempunyai bobot. isi terlebih dahulu</span>
                        <?php endif; ?>
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

          });
        </script>
        <?= $this->endSection() ?>