<?php

namespace App\Models;

use CodeIgniter\Model;


class Persyaratan_Model extends Model
{

    protected $table = 'persyaratan';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['kd_persyaratan', 'nm_persyaratan', 'id_beasiswa', 'type_persyaratan'];
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $column_order = array('id', 'kd_persyaratan', 'nm_persyaratan');
    protected $column_search = array('kd_persyaratan', 'nm_persyaratan');
    protected $order = array('id' => 'asc');
    protected $request;
    protected $db;
    protected $dt;


    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->dt = $this->db->table($this->table);
    }

    private function _get_datatables_query()
    {
        $i = 0;
        $this->dt->select('persyaratan.*,beasiswa.nm_beasiswa')->join('beasiswa', 'beasiswa.id=persyaratan.id_beasiswa')->where('beasiswa.deleted_at', NULL)->where('persyaratan.deleted_at', NULL);
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table)->where('deleted_at', NULL);
        return $tbl_storage->countAllResults();
    }

    public function savePersyaratan(array $data)
    {
        if ($data['type_persyaratan'] != 'pilihan') {
            unset($data['nama_pilihan']);
            unset($data['nilai_pilihan']);

            $this->save($data);

            $id =  $this->getInsertID();
            return $id;
        }

        $this->db->transBegin();

        $persyaratan = [
            'kd_persyaratan' => $data['kd_persyaratan'],
            'nm_persyaratan' => $data['nm_persyaratan'],
            'id_beasiswa' => $data['id_beasiswa'],
            'type_persyaratan' => $data['type_persyaratan']
        ];

        $this->save($persyaratan);
        $id_persyaratan = $this->getInsertID();

        $modelPilihanPersyaratan = new PilihanPersyartanModel();

        $jumlahPilihanPersyaratan = count($data['nama_pilihan']);

        for ($i = 0; $i < $jumlahPilihanPersyaratan; $i++) {
            $dataPersyaratan = [
                'id_persyaratan' => $id_persyaratan,
                'pilihan' => $data['nama_pilihan'][$i],
                'nilai_pilihan' => (int) $data['nilai_pilihan'][$i]
            ];

            $modelPilihanPersyaratan->save($dataPersyaratan);
        }

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        }
        $this->db->transCommit();
        return true;
    }

    public function updatePersyaratan(array $data)
    {
        $psModel = new PilihanPersyartanModel();
        $psData = $psModel->where('id_persyaratan', $data['id'])->findAll();

        if ($data['type_persyaratan'] != 'pilihan') {
            unset($data['nama_pilihan']);
            unset($data['nilai_pilihan']);

            if ($psData) {
                $this->db->transBegin();

                $psModel->where('id_persyaratan', $data['id'])->delete();
                $this->save($data);

                if ($this->db->transStatus() === FALSE) {
                    $this->db->transRollback();
                    return false;
                }

                $this->db->transCommit();
                return true;
            }

            $this->save($data);
            return true;
        }

        $this->db->transBegin();

        $persyaratan = [
            'kd_persyaratan' => $data['kd_persyaratan'],
            'nm_persyaratan' => $data['nm_persyaratan'],
            'id_beasiswa' => $data['id_beasiswa'],
            'type_persyaratan' => $data['type_persyaratan'],
            'id' => $data['id']
        ];

        $this->save($persyaratan);

        $jumlahPilihanPersyaratan = count($data['nama_pilihan']);

        if ($psData) {
            $psModel->where('id_persyaratan', $data['id'])->delete();
        }

        for ($i = 0; $i < $jumlahPilihanPersyaratan; $i++) {
            $dataPersyaratan = [
                'id_persyaratan' => $data['id'],
                'pilihan' => $data['nama_pilihan'][$i],
                'nilai_pilihan' => (int) $data['nilai_pilihan'][$i]
            ];

            $psModel->save($dataPersyaratan);
        }

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        }

        $this->db->transCommit();
        return true;
    }

    public function deletePersyaratan($id)
    {
        $this->db->transBegin();

        $psModel = new PilihanPersyartanModel();
        $psData = $psModel->where('id_persyaratan', $id)->findAll();

        if ($psData) {
            $psModel->where('id_persyaratan', $id)->delete();
        }

        $this->delete($id);
    }
}
