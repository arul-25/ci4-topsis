<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeleksiSeeder extends Seeder
{
	public function run()
	{
		$model = model('Seleksi_Model');

		$model->insert([
			'kd_seleksi' => 'S21001',
			'thn_akademik' => '2021',
			'id_beasiswa' => 1,
			'id_mahasiswa' => 1,
			'tgl_seleksi' => '2021-07-28',
			'id_prodi' => 1,
			'nilai' => 0.007500085514038801
		]);

		$model->insert([
			'kd_seleksi' => 'S21002',
			'thn_akademik' => '2021',
			'id_beasiswa' => 1,
			'id_mahasiswa' => 3,
			'tgl_seleksi' => '2021-07-31',
			'id_prodi' => 2,
			'nilai' => 0.0010000071488320827
		]);

		$model->insert([
			'kd_seleksi' => 'S21003',
			'thn_akademik' => '2021',
			'id_beasiswa' => 1,
			'id_mahasiswa' => 4,
			'tgl_seleksi' => '2021-07-31',
			'id_prodi' => 1,
			'nilai' => 0.0070000071488320827
		]);
	}
}
