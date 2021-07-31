<?php

namespace App\Controllers;

use App\Models\User_Model;


class LoginController extends BaseController
{

	public function __construct()
	{
		helper(['url', 'form', 'general']);
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->user = new User_Model();
	}

	public function index()
	{
		if (session()->get('isLoggedIn') == TRUE) {
			return redirect()->to(base_url('dashboard'));
		}
		return view('login');
	}

	public function check()
	{
		$username 	= $this->request->getVar('username');
		$password 	= $this->request->getVar('password');

		$data = [
			'username' => $username,
			'password' => $password
		];

		if ($this->validation->run($data, 'loginUser') == FALSE) {
			session()->setFlashdata('errors', 'Username dan Password wajib diisi');
			return redirect()->to(base_url('login'));
		} else {

			$query = $this->user->where('username', $username)->first();

			if ($query != '') {
				$session = [
					'uid'     	 => $query['id'],
					'username'   => $query['username'],
					'nama'       => $query['nama'],
					'level'      => $query['level'],
					'id_prodi' => $query['level'] == 'prodiTi' ? 1 : 2,
					'isLoggedIn' => TRUE
				];
				if (password_verify($password, $query['password'])) {
					if ($query['deleted_at'] == NULL) {
						session()->set($session);
						return redirect()->to(base_url('dashboard'));
					} else {
						session()->setFlashdata('errors', 'Akun tidak aktif');
						return redirect()->to(base_url(''));
					}
				} else {
					session()->setFlashdata('errors', 'Username atau Password salah');
					return redirect()->to(base_url(''));
				}
			} else {
				session()->setFlashdata('errors', 'Akun anda belum terdaftar');
				return redirect()->to(base_url(''));
			}
		}
	}
}
