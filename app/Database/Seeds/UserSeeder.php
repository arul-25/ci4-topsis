<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		$model = model('User_Model');

		$model->insert([
			'kd_user' => 'U-002',
			'nama' => 'Prodi Teknik Informatika',
			'username' => 'prodiTi',
			'password' => password_hash('prodiTi', PASSWORD_DEFAULT),
			'level' => 'proditi',
			'jabatan' => 'Staff'
		]);

		$model->insert([
			'kd_user' => 'U-003',
			'nama' => 'Prodi Sistem Informasi',
			'username' => 'prodiSi',
			'password' => password_hash('prodiSi', PASSWORD_DEFAULT),
			'level' => 'prodisi',
			'jabatan' => 'Staff'
		]);
	}
}
