<?php

namespace App\Controllers;

require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';

use App\Models\User_Model;
use App\Models\Prodi_Model;
use App\Models\Mahasiswa_Model;
use App\Models\Beasiswa_Model;
use App\Models\Persyaratan_Model;
use App\Models\Kouta_Model;
use App\Models\Bobot_Model;
use App\Models\Seleksi_Model;
use App\Models\SeleksiDetail_Model;
use App\Libraries\Service_Lib;
use App\Libraries\PDF;
use App\Models\PilihanPersyartanModel;
use Config\Services;
use Mpdf\Mpdf;
use \TCPDF;

class DashboardController extends BaseController
{

	public function __construct()
	{
		helper(['url', 'form', 'general']);
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->user = new User_Model();
		$this->prodi = new Prodi_Model();
		$this->mahasiswa = new Mahasiswa_Model();
		$this->beasiswa = new Beasiswa_Model();
		$this->persyaratan = new Persyaratan_Model();
		$this->kouta = new Kouta_Model();
		$this->bobot = new Bobot_Model();
		$this->seleksi = new Seleksi_Model();
		$this->seleksi_detail = new SeleksiDetail_Model();

		$this->service_lib = new Service_Lib();
	}

	public function index()
	{
		$data = [
			'title' => 'SPK Topsis'
		];
		return view('dashboard', $data);
	}

	public function prodi()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('prodi', $data);
	}

	public function prodi_list()
	{
		$request = Services::request();
		$m = new Prodi_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->kd_prodi;
				$row[] = $list->nm_prodi;
				$row[] = '<a href="' . base_url('dashboard/prodi_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteProdi(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function prodi_add()
	{
		$data = [
			'title' => 'SPK Topsis'
		];
		return view('prodi/prodi_add', $data);
	}

	public function prodi_store()
	{
		$kd_prodi = $this->request->getVar('kd_prodi');
		$nm_prodi = $this->request->getVar('nm_prodi');

		$validasi = [
			'kd_prodi' => $kd_prodi,
			'nm_prodi' => $nm_prodi
		];

		if ($this->validation->run($validasi, 'insertProdi') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors()
			];
			return view('prodi/prodi_add', $data);
		} else {
			$insert = [
				'kd_prodi' => $kd_prodi,
				'nm_prodi' => $nm_prodi
			];

			$save = $this->prodi->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data prodi berhasil');
				return redirect()->to(base_url('dashboard/prodi'));
			} else {
				session()->setFlashdata('errors', 'Tambah data prodi gagal');
				return redirect()->to(base_url('dashboard/prodi'));
			}
		}
	}

	public function prodi_edit($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->prodi->find(dekrip($id)),
			'id' => $id
		];
		return view('prodi/prodi_edit', $data);
	}

	public function prodi_update()
	{
		$dekrip = $this->request->getVar('id');
		$kd_prodi = $this->request->getVar('kd_prodi');
		$kd_prodi_old = $this->request->getVar('kd_prodi_old');
		$nm_prodi = $this->request->getVar('nm_prodi');
		$id = dekrip($dekrip);

		$validasi = [
			'kd_prodi' => $kd_prodi,
			'nm_prodi' => $nm_prodi
		];

		if ($this->validation->run($validasi, 'updateProdi') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->prodi->find($id),
				'id' => $dekrip
			];
			return view('prodi/prodi_edit', $data);
		} else {
			if ($kd_prodi != $kd_prodi_old && $this->prodi->where('kd_prodi', $kd_prodi)->countAllResults() > 0) {
				$data = [
					'title' => 'SPK Topsis',
					'validation' => ['kd_prodi' => 'Kode Prodi sudah terdaftar di database'],
					'data' => $this->prodi->find($id),
					'id' => $dekrip
				];
				return view('prodi/prodi_edit', $data);
			} else {
				$edit = [
					'kd_prodi' => $kd_prodi,
					'nm_prodi' => $nm_prodi
				];
				$update = $this->prodi->where('id', $id)->set($edit)->update();
				if ($update) {
					session()->setFlashdata('success', 'Update data prodi berhasil');
					return redirect()->to(base_url('dashboard/prodi'));
				} else {
					session()->setFlashdata('errors', 'Update data prodi gagal');
					return redirect()->to(base_url('dashboard/prodi'));
				}
			}
		}
	}

	public function prodi_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->prodi->delete($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data prodi berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data prodi gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function mahasiswa()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('mahasiswa', $data);
	}

	public function mahasiswa_list()
	{
		$request = Services::request();
		$m = new Mahasiswa_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->npm;
				$row[] = $list->nama;
				$row[] = $list->nm_prodi;
				$row[] = '<a href="' . base_url('dashboard/mahasiswa_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteMahasiswa(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function mahasiswa_add()
	{
		$data = [
			'title' => 'SPK Topsis',
			'prodi' => $this->prodi->findAll()
		];
		return view('mahasiswa/mahasiswa_add', $data);
	}

	public function mahasiswa_store()
	{
		$npm = $this->request->getVar('npm');
		$nama = $this->request->getVar('nama');
		$jk = $this->request->getVar('jk');
		$umur = $this->request->getVar('umur');
		$asal_slta = $this->request->getVar('asal_slta');
		$jurusan_slta = $this->request->getVar('jurusan_slta');
		$thn_lulus = $this->request->getVar('thn_lulus');
		$id_prodi = $this->request->getVar('id_prodi');

		$validasi = [
			'npm' => $npm,
			'nama' => $nama,
			'jk' => $jk,
			'umur' => $umur,
			'asal_slta' => $asal_slta,
			'jurusan_slta' => $jurusan_slta,
			'thn_lulus' => $thn_lulus,
			'id_prodi' => $id_prodi
		];

		if ($this->validation->run($validasi, 'insertMahasiswa') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'prodi' => $this->prodi->findAll(),
				'validation' => $this->validation->getErrors()
			];
			return view('mahasiswa/mahasiswa_add', $data);
		} else {
			$insert = [
				'npm' => $npm,
				'nama' => $nama,
				'jk' => $jk,
				'umur' => $umur,
				'asal_slta' => $asal_slta,
				'jurusan_slta' => $jurusan_slta,
				'thn_lulus' => $thn_lulus,
				'id_prodi' => $id_prodi
			];

			$save = $this->mahasiswa->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data mahasiswa berhasil');
				return redirect()->to(base_url('dashboard/mahasiswa'));
			} else {
				session()->setFlashdata('errors', 'Tambah data mahasiswa gagal');
				return redirect()->to(base_url('dashboard/mahasiswa'));
			}
		}
	}

	public function mahasiswa_edit($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'prodi' => $this->prodi->findAll(),
			'data' => $this->mahasiswa->find(dekrip($id)),
			'id' => $id
		];
		return view('mahasiswa/mahasiswa_edit', $data);
	}

	public function mahasiswa_update()
	{
		$dekrip = $this->request->getVar('id');
		$npm = $this->request->getVar('npm');
		$npm_old = $this->request->getVar('npm_old');
		$nama = $this->request->getVar('nama');
		$jk = $this->request->getVar('jk');
		$umur = $this->request->getVar('umur');
		$asal_slta = $this->request->getVar('asal_slta');
		$jurusan_slta = $this->request->getVar('jurusan_slta');
		$thn_lulus = $this->request->getVar('thn_lulus');
		$id_prodi = $this->request->getVar('id_prodi');
		$id = dekrip($dekrip);

		$validasi = [
			'npm' => $npm,
			'nama' => $nama,
			'jk' => $jk,
			'umur' => $umur,
			'asal_slta' => $asal_slta,
			'jurusan_slta' => $jurusan_slta,
			'thn_lulus' => $thn_lulus,
			'id_prodi' => $id_prodi
		];

		if ($this->validation->run($validasi, 'updateMahasiswa') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'prodi' => $this->prodi->findAll(),
				'data' => $this->mahasiswa->find($id),
				'id' => $dekrip
			];
			return view('mahasiswa/mahasiswa_edit', $data);
		} else {
			if ($npm != $npm_old && $this->mahasiswa->where('npm', $npm)->countAllResults() > 0) {
				$data = [
					'title' => 'SPK Topsis',
					'validation' => ['npm' => 'NPM sudah terdaftar di database'],
					'data' => $this->mahasiswa->find($id),
					'prodi' => $this->prodi->findAll(),
					'id' => $dekrip
				];
				return view('mahasiswa/mahasiswa_edit', $data);
			} else {
				$edit = [
					'npm' => $npm,
					'nama' => $nama,
					'jk' => $jk,
					'umur' => $umur,
					'asal_slta' => $asal_slta,
					'jurusan_slta' => $jurusan_slta,
					'thn_lulus' => $thn_lulus,
					'id_prodi' => $id_prodi
				];
				$update = $this->mahasiswa->where('id', $id)->set($edit)->update();
				if ($update) {
					session()->setFlashdata('success', 'Update data mahasiswa berhasil');
					return redirect()->to(base_url('dashboard/mahasiswa'));
				} else {
					session()->setFlashdata('errors', 'Update data mahasiswa gagal');
					return redirect()->to(base_url('dashboard/mahasiswa'));
				}
			}
		}
	}

	public function mahasiswa_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->mahasiswa->delete($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data mahasiswa berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data mahasiswa gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function beasiswa()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('beasiswa', $data);
	}

	public function beasiswa_list()
	{
		$request = Services::request();
		$m = new Beasiswa_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->kd_beasiswa;
				$row[] = $list->nm_beasiswa;
				$row[] = $list->sumber;
				$row[] = rupiah($list->jumlah);
				$row[] = '<a href="' . base_url('dashboard/beasiswa_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteBeasiswa(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function beasiswa_add()
	{
		$data = [
			'title' => 'SPK Topsis'
		];
		return view('beasiswa/beasiswa_add', $data);
	}

	public function beasiswa_store()
	{
		$kd_beasiswa = $this->request->getVar('kd_beasiswa');
		$nm_beasiswa = $this->request->getVar('nm_beasiswa');
		$sumber = $this->request->getVar('sumber');
		$jumlah = $this->request->getVar('jumlah');

		$validasi = [
			'kd_beasiswa' => $kd_beasiswa,
			'nm_beasiswa' => $nm_beasiswa,
			'sumber' => $sumber,
			'jumlah' => $jumlah
		];

		if ($this->validation->run($validasi, 'insertBeasiswa') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors()
			];
			return view('beasiswa/beasiswa_add', $data);
		} else {
			$insert = [
				'kd_beasiswa' => $kd_beasiswa,
				'nm_beasiswa' => $nm_beasiswa,
				'sumber' => $sumber,
				'jumlah' => $jumlah
			];

			$save = $this->beasiswa->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data beasiswa berhasil');
				return redirect()->to(base_url('dashboard/beasiswa'));
			} else {
				session()->setFlashdata('errors', 'Tambah data beasiswa gagal');
				return redirect()->to(base_url('dashboard/beasiswa'));
			}
		}
	}

	public function beasiswa_edit($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->beasiswa->find(dekrip($id)),
			'id' => $id
		];
		return view('beasiswa/beasiswa_edit', $data);
	}

	public function beasiswa_update()
	{
		$dekrip = $this->request->getVar('id');
		$kd_beasiswa = $this->request->getVar('kd_beasiswa');
		$nm_beasiswa = $this->request->getVar('nm_beasiswa');
		$sumber = $this->request->getVar('sumber');
		$jumlah = $this->request->getVar('jumlah');
		$id = dekrip($dekrip);

		$validasi = [
			'kd_beasiswa' => $kd_beasiswa,
			'nm_beasiswa' => $nm_beasiswa,
			'sumber' => $sumber,
			'jumlah' => $jumlah
		];

		if ($this->validation->run($validasi, 'insertBeasiswa') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->beasiswa->find($id),
				'id' => $dekrip
			];
			return view('beasiswa/beasiswa_edit', $data);
		} else {

			$edit = [
				'kd_beasiswa' => $kd_beasiswa,
				'nm_beasiswa' => $nm_beasiswa,
				'sumber' => $sumber,
				'jumlah' => $jumlah
			];
			$update = $this->beasiswa->where('id', $id)->set($edit)->update();
			if ($update) {
				session()->setFlashdata('success', 'Update data beasiswa berhasil');
				return redirect()->to(base_url('dashboard/beasiswa'));
			} else {
				session()->setFlashdata('errors', 'Update data beasiswa gagal');
				return redirect()->to(base_url('dashboard/beasiswa'));
			}
		}
	}

	public function beasiswa_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->beasiswa->delete($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data beasiswa berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data beasiswa gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function kouta()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('kouta', $data);
	}

	public function kouta_list()
	{
		$request = Services::request();
		$m = new Kouta_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->thn_akademik;
				$row[] = $list->nm_beasiswa;
				$row[] = $list->nm_prodi;
				$row[] = rupiah($list->kouta);
				$row[] = '<a href="' . base_url('dashboard/kouta_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteKouta(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function kouta_add()
	{
		$data = [
			'title' => 'SPK Topsis',
			'beasiswa' => $this->beasiswa->findAll(),
			'prodi' => $this->prodi->findAll()
		];
		return view('kouta/kouta_add', $data);
	}

	public function kouta_store()
	{
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$id_prodi = $this->request->getVar('id_prodi');
		$kouta = $this->request->getVar('kouta');

		$validasi = [
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_prodi' => $id_prodi,
			'kouta' => $kouta
		];

		if ($this->validation->run($validasi, 'insertKouta') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'beasiswa' => $this->beasiswa->findAll(),
				'prodi' => $this->prodi->findAll()
			];
			return view('kouta/kouta_add', $data);
		} else {
			$insert = [
				'thn_akademik' => $thn_akademik,
				'id_beasiswa' => $id_beasiswa,
				'id_prodi' => $id_prodi,
				'kouta' => $kouta
			];

			$save = $this->kouta->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data kouta berhasil');
				return redirect()->to(base_url('dashboard/kouta'));
			} else {
				session()->setFlashdata('errors', 'Tambah data kouta gagal');
				return redirect()->to(base_url('dashboard/kouta'));
			}
		}
	}

	public function kouta_edit($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->kouta->find(dekrip($id)),
			'beasiswa' => $this->beasiswa->findAll(),
			'prodi' => $this->prodi->findAll(),
			'id' => $id
		];
		return view('kouta/kouta_edit', $data);
	}

	public function kouta_update()
	{
		$dekrip = $this->request->getVar('id');
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$id_prodi = $this->request->getVar('id_prodi');
		$kouta = $this->request->getVar('kouta');
		$id = dekrip($dekrip);

		$validasi = [
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_prodi' => $id_prodi,
			'kouta' => $kouta
		];

		if ($this->validation->run($validasi, 'insertKouta') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->kouta->find($id),
				'beasiswa' => $this->beasiswa->findAll(),
				'prodi' => $this->prodi->findAll(),
				'id' => $dekrip
			];
			return view('kouta/kouta_edit', $data);
		} else {

			$edit = [
				'thn_akademik' => $thn_akademik,
				'id_beasiswa' => $id_beasiswa,
				'id_prodi' => $id_prodi,
				'kouta' => $kouta
			];
			$update = $this->kouta->where('id', $id)->set($edit)->update();
			if ($update) {
				session()->setFlashdata('success', 'Update data kouta berhasil');
				return redirect()->to(base_url('dashboard/kouta'));
			} else {
				session()->setFlashdata('errors', 'Update data kouta gagal');
				return redirect()->to(base_url('dashboard/kouta'));
			}
		}
	}

	public function kouta_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->kouta->delete($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data kouta berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data kouta gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function persyaratan()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('persyaratan', $data);
	}

	public function persyaratan_list()
	{
		$request = Services::request();
		$m = new Persyaratan_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->kd_persyaratan;
				$row[] = $list->nm_persyaratan;
				$row[] = $list->nm_beasiswa;
				$row[] = $list->type_persyaratan;
				$row[] = '<a href="' . base_url('dashboard/persyaratan_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deletePersyaratan(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function persyaratan_add()
	{
		$data = [
			'title' => 'SPK Topsis',
			'beasiswa' => $this->beasiswa->findAll()
		];
		return view('persyaratan/persyaratan_add', $data);
	}

	public function persyaratan_store()
	{
		$kd_persyaratan = $this->request->getVar('kd_persyaratan');
		$nm_persyaratan = $this->request->getVar('nm_persyaratan');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$type_persyaratan = $this->request->getVar('type_persyaratan');
		$nama_pilihan = $this->request->getVar('nama_pilihan');
		$nilai_pilihan = $this->request->getVar('nilai_pilihan');

		$validasi = [
			'kd_persyaratan' => $kd_persyaratan,
			'nm_persyaratan' => $nm_persyaratan,
			'id_beasiswa' => $id_beasiswa,
			'type_persyaratan' => $type_persyaratan
		];

		if ($this->validation->run($validasi, 'insertPersyaratan') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'beasiswa' => $this->beasiswa->findAll()
			];
			return view('persyaratan/persyaratan_add', $data);
		} else {
			$insert = [
				'kd_persyaratan' => $kd_persyaratan,
				'nm_persyaratan' => $nm_persyaratan,
				'id_beasiswa' => $id_beasiswa,
				'type_persyaratan' => $type_persyaratan,
				'nama_pilihan' => $nama_pilihan,
				'nilai_pilihan' => $nilai_pilihan
			];

			$save = $this->persyaratan->savePersyaratan($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data persyaratan berhasil');
				return redirect()->to(base_url('dashboard/persyaratan'));
			} else {
				session()->setFlashdata('errors', 'Tambah data persyaratan gagal');
				return redirect()->to(base_url('dashboard/persyaratan'));
			}
		}
	}

	public function persyaratan_edit($id)
	{
		$psModel = new PilihanPersyartanModel();
		$dataPersyaratan = $this->persyaratan->find(dekrip($id));
		$dataPilihanPersyaratan = $dataPersyaratan ? $psModel->where('id_persyaratan', dekrip($id))->findAll() : null;
		$data = [
			'title' => 'SPK Topsis',
			'data' => $dataPersyaratan,
			'beasiswa' => $this->beasiswa->findAll(),
			'pilihan_persyaratan' => $dataPilihanPersyaratan,
			'validation' => $this->validation->getErrors(),
			'id' => $id
		];
		return view('persyaratan/persyaratan_edit', $data);
	}

	public function persyaratan_update()
	{
		$dekrip = $this->request->getVar('id');
		$kd_persyaratan = $this->request->getVar('kd_persyaratan');
		$kd_persyaratan_old = $this->request->getVar('kd_persyaratan_old');
		$nm_persyaratan = $this->request->getVar('nm_persyaratan');
		$type_persyaratan = $this->request->getVar('type_persyaratan');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$nama_pilihan = $this->request->getVar('nama_pilihan');
		$nilai_pilihan = $this->request->getVar('nilai_pilihan');
		$id = dekrip($dekrip);

		$psModel = new PilihanPersyartanModel();
		$rules = $this->validation->getRuleGroup('insertPersyaratan');

		if ($kd_persyaratan != $kd_persyaratan_old && count($this->persyaratan->where('kd_persyaratan', $kd_persyaratan)->findAll()) > 0) {
			$rules['kd_persyaratan']['rules'] = "required|is_unique[persyaratan.kd_persyaratan]";
			$rules['kd_persyaratan']['errors'] = [
				'is_unique' => '{field} sudah digunakan. ganti dengan yang lain'
			];
		}

		if (!$this->validate($rules)) {
			$dataPilihanPersyaratan = $psModel->where('id_persyaratan', $id)->findAll();
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->persyaratan->find($id),
				'beasiswa' => $this->beasiswa->findAll(),
				'pilihan_persyaratan' => $dataPilihanPersyaratan,
				'id' => $dekrip
			];
			return view('persyaratan/persyaratan_edit', $data);
		} else {

			$insert = [
				'kd_persyaratan' => $kd_persyaratan,
				'nm_persyaratan' => $nm_persyaratan,
				'id_beasiswa' => $id_beasiswa,
				'type_persyaratan' => $type_persyaratan,
				'nama_pilihan' => $nama_pilihan,
				'nilai_pilihan' => $nilai_pilihan,
				'id' => $id
			];
			$update = $this->persyaratan->updatePersyaratan($insert);
			if ($update) {
				session()->setFlashdata('success', 'Update data persyaratan berhasil');
				return redirect()->to(base_url('dashboard/persyaratan'));
			} else {
				session()->setFlashdata('errors', 'Update data persyaratan gagal');
				return redirect()->to(base_url('dashboard/persyaratan'));
			}
		}
	}

	public function persyaratan_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->persyaratan->deletePersyaratan($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data persyaratan berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data persyaratan gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function bobot()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('bobot', $data);
	}

	public function bobot_list()
	{
		$request = Services::request();
		$m = new Bobot_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->thn_akademik;
				$row[] = $list->nm_persyaratan;
				$row[] = $list->bobot;
				$row[] = '<a href="' . base_url('dashboard/bobot_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteBobot(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function bobot_add()
	{
		$bobot = $this->bobot->select('id_persyaratan')->findAll();
		$id_bobot = [];

		foreach ($bobot as $row) {
			$id_bobot[] = $row['id_persyaratan'];
		}
		$data = [
			'title' => 'SPK Topsis',
			'persyaratan' => $this->persyaratan->findAll(),
			'bobot' => $id_bobot
		];
		return view('bobot/bobot_add', $data);
	}

	public function bobot_store()
	{
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_persyaratan = $this->request->getVar('id_persyaratan');
		$bobot = $this->request->getVar('bobot');

		$validasi = [
			'thn_akademik' => $thn_akademik,
			'id_persyaratan' => $id_persyaratan,
			'bobot' => $bobot
		];

		if ($this->validation->run($validasi, 'insertBobot') == FALSE) {
			$bobot = $this->bobot->select('id_persyaratan')->findAll();
			$id_bobot = [];

			foreach ($bobot as $row) {
				$id_bobot[] = $row['id_persyaratan'];
			}
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'persyaratan' => $this->persyaratan->findAll(),
				'bobot' => $id_bobot
			];
			return view('bobot/bobot_add', $data);
		} else {
			$insert = [
				'thn_akademik' => $thn_akademik,
				'id_persyaratan' => $id_persyaratan,
				'bobot' => $bobot
			];

			$save = $this->bobot->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data bobot berhasil');
				return redirect()->to(base_url('dashboard/bobot'));
			} else {
				session()->setFlashdata('errors', 'Tambah data bobot gagal');
				return redirect()->to(base_url('dashboard/bobot'));
			}
		}
	}

	public function bobot_edit($id)
	{
		$bobot = $this->bobot->select('id_persyaratan')->findAll();
		$id_bobot = [];

		foreach ($bobot as $row) {
			$id_bobot[] = $row['id_persyaratan'];
		}

		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->bobot->find(dekrip($id)),
			'persyaratan' => $this->persyaratan->findAll(),
			'id_bobot' => $id_bobot,
			'id' => $id
		];
		return view('bobot/bobot_edit', $data);
	}

	public function bobot_update()
	{
		$dekrip = $this->request->getVar('id');
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_persyaratan = $this->request->getVar('id_persyaratan');
		$bobot = $this->request->getVar('bobot');
		$id = dekrip($dekrip);

		$validasi = [
			'thn_akademik' => $thn_akademik,
			'id_persyaratan' => $id_persyaratan,
			'bobot' => $bobot
		];

		if ($this->validation->run($validasi, 'insertBobot') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->bobot->find($id),
				'persyaratan' => $this->persyaratan->findAll(),
				'id' => $dekrip
			];
			return view('bobot/bobot_edit', $data);
		} else {

			$edit = [
				'thn_akademik' => $thn_akademik,
				'id_persyaratan' => $id_persyaratan,
				'bobot' => $bobot
			];
			$update = $this->bobot->where('id', $id)->set($edit)->update();
			if ($update) {
				session()->setFlashdata('success', 'Update data bobot berhasil');
				return redirect()->to(base_url('dashboard/bobot'));
			} else {
				session()->setFlashdata('errors', 'Update data bobot gagal');
				return redirect()->to(base_url('dashboard/bobot'));
			}
		}
	}

	public function bobot_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->bobot->delete($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data bobot berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data bobot gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function seleksi()
	{
		$data = [
			'title' => 'SPK Topsis'
		];

		return view('seleksi', $data);
	}

	public function seleksi_list()
	{
		$request = Services::request();
		$m = new Seleksi_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->kd_seleksi;
				$row[] = $list->thn_akademik;
				$row[] = $list->nm_beasiswa;
				$row[] = $list->npm;
				$row[] = $list->nama;
				$row[] = $list->nm_prodi;
				$row[] = '<a href="' . base_url('dashboard/seleksi_detail/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-search"></i></a> &nbsp; <a href="' . base_url('dashboard/seleksi_edit/' . enkrip($list->id)) . '" class="text-secondary"><i class="fa fa-pencil-alt"></i></a> &nbsp; <a href="#" onClick="return deleteSeleksi(' . $list->id . ')" class="text-secondary"><i class="fa fa-trash"></i></a>';
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function hitung()
	{
		if ($this->request->getVar('id_prodi') && $this->request->getVar('id_beasiswa') && $this->request->getVar('thn_akademik')) {
			$thn_akademik = $this->request->getVar('thn_akademik');
			$id_beasiswa = $this->request->getVar('id_beasiswa');
			$id_prodi = $this->request->getVar('id_prodi');
		} else {
			$thn_akademik = '';
			$id_beasiswa = '';
			$id_prodi = '';
		}

		$perhitungan = $this->service_lib->perhitungan($thn_akademik, $id_beasiswa, $id_prodi);

		$data = [
			'title' => 'SPK Topsis',
			'beasiswa' => $this->beasiswa->findAll(),
			'prodi' => $this->prodi->findAll(),
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_prodi' => $id_prodi,
			'perhitungan' => $perhitungan
		];

		return view('hitung', $data);
	}

	public function hasil()
	{
		if ($this->request->getVar('id_prodi') && $this->request->getVar('id_beasiswa') && $this->request->getVar('thn_akademik')) {
			$thn_akademik = $this->request->getVar('thn_akademik');
			$id_beasiswa = $this->request->getVar('id_beasiswa');
			$id_prodi = $this->request->getVar('id_prodi');
			$perhitungan = $this->service_lib->perhitungan($thn_akademik, $id_beasiswa, $id_prodi);
			if ($perhitungan == null) return redirect()->to(base_url('dashboard/hasil'));
		} else {
			$thn_akademik = '';
			$id_beasiswa = '';
			$id_prodi = '';
		}

		$data = [
			'title' => 'SPK Topsis',
			'beasiswa' => $this->beasiswa->findAll(),
			'prodi' => $this->prodi->find(session()->get('id_prodi')),
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_prodi' => $id_prodi,
			'data' => $this->seleksi->select('id_mahasiswa, nilai')->where('id_prodi', session()->get('id_prodi'))->where('nilai !=', 'null')->orderBy('nilai', 'DESC')->findAll(),
			// 'data' => $perhitungan,
			'lib' => $this->service_lib
		];

		return view('hasil', $data);
	}

	public function hasil_list()
	{
		$request = Services::request();
		$m = new Seleksi_Model($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $m->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];
				$row[] = $no;
				$row[] = $list->kd_seleksi;
				$row[] = $list->thn_akademik;
				$row[] = $list->nm_beasiswa;
				$row[] = $list->npm;
				$row[] = $list->nama;
				$row[] = $list->nm_prodi;
				$row[] = $list->nilai;
				$row[] = $no;
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $m->count_all(),
				"recordsFiltered" => $m->count_filtered(),
				"data" => $data
			];
			return json_encode($output);
		}
	}

	public function seleksi_add()
	{
		$data = [
			'title' => 'SPK Topsis',
			'beasiswa' => $this->beasiswa->findAll(),
			'mahasiswa' => $this->mahasiswa->where('id_prodi', session()->get('id_prodi'))->findAll()
		];
		return view('seleksi/seleksi_add', $data);
	}

	public function seleksi_store()
	{
		$kd_seleksi = $this->request->getVar('kd_seleksi');
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$id_mahasiswa = $this->request->getVar('id_mahasiswa');
		$data_mahasiswa = $this->mahasiswa->where('id', $id_mahasiswa)->first();
		$id_prodi = $data_mahasiswa['id_prodi'];
		$tgl_seleksi = $this->request->getVar('tgl_seleksi');

		$validasi = [
			'kd_seleksi' => $kd_seleksi,
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_mahasiswa' => $id_mahasiswa,
			'tgl_seleksi' => $tgl_seleksi
		];

		if ($this->validation->run($validasi, 'insertSeleksi') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'beasiswa' => $this->beasiswa->findAll(),
				'mahasiswa' => $this->mahasiswa->findAll()
			];
			return view('seleksi/seleksi_add', $data);
		} else {
			$insert = [
				'kd_seleksi' => $kd_seleksi,
				'thn_akademik' => $thn_akademik,
				'id_beasiswa' => $id_beasiswa,
				'id_mahasiswa' => $id_mahasiswa,
				'tgl_seleksi' => $tgl_seleksi,
				'id_prodi' => $id_prodi
			];

			$save = $this->seleksi->save($insert);
			if ($save) {
				session()->setFlashdata('success', 'Tambah data seleksi berhasil');
				return redirect()->to(base_url('dashboard/seleksi'));
			} else {
				session()->setFlashdata('errors', 'Tambah data seleksi gagal');
				return redirect()->to(base_url('dashboard/seleksi'));
			}
		}
	}

	public function seleksi_edit($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->seleksi->find(dekrip($id)),
			'beasiswa' => $this->beasiswa->findAll(),
			'mahasiswa' => $this->mahasiswa->findAll(),
			'id' => $id
		];
		return view('seleksi/seleksi_edit', $data);
	}

	public function seleksi_update()
	{
		$dekrip = $this->request->getVar('id');
		$kd_seleksi = $this->request->getVar('kd_seleksi');
		$thn_akademik = $this->request->getVar('thn_akademik');
		$id_beasiswa = $this->request->getVar('id_beasiswa');
		$id_mahasiswa = $this->request->getVar('id_mahasiswa');
		$data_mahasiswa = $this->mahasiswa->where('id', $id_mahasiswa)->first();
		$id_prodi = $data_mahasiswa['id_prodi'];
		$tgl_seleksi = $this->request->getVar('tgl_seleksi');
		$id = dekrip($dekrip);

		$validasi = [
			'kd_seleksi' => $kd_seleksi,
			'thn_akademik' => $thn_akademik,
			'id_beasiswa' => $id_beasiswa,
			'id_mahasiswa' => $id_mahasiswa,
			'tgl_seleksi' => $tgl_seleksi
		];

		if ($this->validation->run($validasi, 'insertSeleksi') == FALSE) {
			$data = [
				'title' => 'SPK Topsis',
				'validation' => $this->validation->getErrors(),
				'data' => $this->seleksi->find($id),
				'beasiswa' => $this->beasiswa->findAll(),
				'mahasiswa' => $this->mahasiswa->findAll(),
				'id' => $dekrip
			];
			return view('seleksi/seleksi_edit', $data);
		} else {

			$edit = [
				'kd_seleksi' => $kd_seleksi,
				'thn_akademik' => $thn_akademik,
				'id_beasiswa' => $id_beasiswa,
				'id_mahasiswa' => $id_mahasiswa,
				'tgl_seleksi' => $tgl_seleksi,
				'id_prodi' => $id_prodi
			];
			$update = $this->seleksi->where('id', $id)->set($edit)->update();
			if ($update) {
				session()->setFlashdata('success', 'Update data seleksi berhasil');
				return redirect()->to(base_url('dashboard/seleksi'));
			} else {
				session()->setFlashdata('errors', 'Update data seleksi gagal');
				return redirect()->to(base_url('dashboard/seleksi'));
			}
		}
	}

	public function seleksi_delete()
	{
		$input = $this->request->getRawInput();
		$id_en = $input['id'];
		$id = dekrip($id_en);

		$delete = $this->seleksi->deleteSeleksi($id);
		if ($delete) {
			$response = [
				'status' => 201,
				'message' => 'Data seleksi berhasil dihapus'
			];
		} else {
			$response = [
				'status' => 500,
				'message' => 'Data seleksi gagal dihapus'
			];
		}

		return $this->response->setJSON($response);
	}

	public function seleksi_detail($id)
	{
		$data = [
			'title' => 'SPK Topsis',
			'data' => $this->seleksi_detail->where('id_seleksi', dekrip($id))->find(),
			'persyaratan' => $this->persyaratan->findAll(),
			'lib' => $this->service_lib,
			'id' => $id,
			'BobotModel' => new Bobot_Model(),
			'PilihanPersyaratanModel' => new PilihanPersyartanModel()
		];
		return view('seleksi/seleksi_detail', $data);
	}

	public function seleksi_detail_update()
	{
		$dekrip = $this->request->getVar('id');
		$id = dekrip($dekrip);
		$id_persyaratan = $this->request->getVar('id_persyaratan');
		$jawaban = $this->request->getVar('jawaban');
		$thn_akademik = $this->request->getVar('thn_akademik');
		$data_seleksi = $this->seleksi->where('id', $id)->first();
		$id_mahasiswa = $data_seleksi['id_mahasiswa'];
		$id_prodi = $data_seleksi['id_prodi'];


		if ($this->seleksi_detail->where('id_seleksi', $id)->where('id_mahasiswa', $id_mahasiswa)->countAllResults() > 0) {
			for ($s = 0; $s < count($id_persyaratan); $s++) {
				$this->seleksi_detail->where('id_seleksi', $id)->where('id_mahasiswa', $id_mahasiswa)->where('id_persyaratan', $id_persyaratan[$s])->set(['jawaban' => $jawaban[$s]])->update();
			}
			session()->setFlashdata('success', 'Update data seleksi berhasil');
			return redirect()->to(base_url('dashboard/seleksi'));
		} else {
			for ($s = 0; $s < count($id_persyaratan); $s++) {
				$save = [
					'id_seleksi' => $id,
					'id_mahasiswa' => $id_mahasiswa,
					'id_persyaratan' => $id_persyaratan[$s],
					'jawaban' => $jawaban[$s],
					'bobot' => $this->service_lib->getBobotPersyaratan($thn_akademik, $id_persyaratan[$s])
				];
				$this->seleksi_detail->save($save);
			}
			session()->setFlashdata('success', 'Update data seleksi berhasil');
			return redirect()->to(base_url('dashboard/seleksi'));
		}
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to(base_url(''));
	}

	public function cetak()
	{
		$html = view('cetak');

		$pdf = new Mpdf();

		$pdf->WriteHTML($html);
		$this->response->setContentType('application/pdf');
		$pdf->Output();
	}
}
