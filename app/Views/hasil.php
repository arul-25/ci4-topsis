        <?= $this->extend('layout/layout') ?>
        <?= $this->section('content') ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Seleksi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Hasil Seleksi</li>
            </ol>

          </div>

          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <!-- <h6 class="m-0 font-weight-bold text-secondary">Data User</h6> -->
                </div>
                <div class="table-responsive p-3">
                  <form action="<?= base_url('dashboard/hasil') ?>" method="post" style="margin-top: 10px;">
                    <div class="form-group row">
                      <label for="thn_akademik" class="col-sm-4 col-form-label">Tahun Akademik</label>
                      <div class="col-sm-8">
                        <input type="number" name="thn_akademik" class="form-control" placeholder="Tahun Akademik" value="<?php echo isset($_POST['thn_akademik']) && $_POST['thn_akademik'] != '' ? $_POST['thn_akademik'] : date('Y'); ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="id_beasiswa" class="col-sm-4 col-form-label">Beasiswa</label>
                      <div class="col-sm-8">
                        <select class="select2-single-placeholder form-control" name="id_beasiswa">
                          <option value="">Select</option>
                          <?php
                          foreach ($beasiswa as $rowb) {
                            echo '<option value="' . $rowb['id'] . '" ' . ((isset($_POST['id_beasiswa']) && $_POST['id_beasiswa'] == $rowb['id']) ? 'selected' : '') . '>[' . $rowb['kd_beasiswa'] . '] ' . $rowb['nm_beasiswa'] . '</option>';
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
                          foreach ($prodi as $rowp) {
                            echo '<option value="' . $rowp['id'] . '" ' . ((isset($_POST['id_beasiswa']) && $_POST['id_prodi'] == $rowb['id']) ? 'selected' : '') . '>[' . $rowp['kd_prodi'] . '] ' . $rowp['nm_prodi'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12" align="right">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="id_beasiswa" class="col-sm-4 col-form-label">Kouta Beasiswa</label>
                      <div class="col-sm-8">
                        <?php
                        $kouta = $lib->getKoutaBeasiswa($thn_akademik, $id_beasiswa, $id_prodi);
                        echo $kouta ? $kouta : 0 . ' orang';
                        ?>
                      </div>
                    </div>
                  </form>
                  <table class="table align-items-center table-flush" id="myTableSeleksi">
                    <thead class="thead-light">
                      <tr>
                        <th style="text-align: center;width: 50px;">No</th>
                        <th style="text-align: center;">NPM</th>
                        <th style="text-align: center;">Nama</th>
                        <th style="text-align: center;">Prodi</th>
                        <th style="text-align: center;">Nilai</th>
                        <th style="text-align: center;">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($_POST['id_beasiswa']) && isset($_POST['id_prodi']) && isset($_POST['thn_akademik'])) {
                        $data_nilai = array();
                        // $data_nilai_new = array();
                        foreach ($data as $key) {
                          $data_nilai[] = array($key['id_mahasiswa'] => $key['nilai']);
                        }

                        // asort($data_nilai);
                        // foreach ($data_nilai as $k => $v) {
                        //   $data_nilai_new[] = array($v);
                        // }

                        $no = 1;
                        foreach ($data_nilai as $row) {
                          $data_mahasiswa = $lib->getAllDataMahasiswa(array_keys($row)[0]);
                          $data_prodi = $lib->getNameProdi($data_mahasiswa->id_prodi);
                          echo '<tr>';
                          echo '<td>' . $no . '</td>';
                          echo '<td>' . $data_mahasiswa->npm . '</td>';
                          echo '<td>' . $data_mahasiswa->nama . '</td>';
                          echo '<td>' . $data_prodi . '</td>';
                          echo '<td>' . array_values($row)[0] . '</td>';
                          echo '<td>' . (($no <= $kouta) ? 'Layak' : 'Tidak Layak') . '</td>';
                          echo '</tr>';
                          $no++;
                        }
                        // foreach ($data_nilai_new as $e => $f) {
                        //   foreach ($f[0] as $keys => $values) {
                        //     $data_mahasiswa = $lib->getAllDataMahasiswa($keys);
                        //     $data_prodi = $lib->getNameProdi($data_mahasiswa->id_prodi);
                        //     echo '<tr>';
                        //     echo '<td>' . $no . '</td>';
                        //     echo '<td>' . $data_mahasiswa->npm . '</td>';
                        //     echo '<td>' . $data_mahasiswa->nama . '</td>';
                        //     echo '<td>' . $data_prodi . '</td>';
                        //     echo '<td>' . $values . '</td>';
                        //     echo '<td>' . (($no <= $kouta) ? 'Layak' : 'Tidak Layak') . '</td>';
                        //     echo '</tr>';
                        //   }
                        //   $no++;
                        // }
                      }
                      // echo '<pre>';
                      //      print_r($data_mahasiswa);
                      //      echo '</pre>';
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
        <script>
          $(document).ready(function() {
            $('#myTableSeleksi').DataTable();
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