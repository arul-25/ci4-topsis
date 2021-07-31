<?php

namespace App\Models;

use CodeIgniter\Model;


class Seleksi_Model extends Model
{

    protected $table = 'seleksi';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['kd_seleksi', 'thn_akademik', 'id_beasiswa', 'id_mahasiswa', 'tgl_seleksi', 'status_terima', 'id_prodi', 'nilai'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $column_order = array('seleksi.id', 'seleksi.kd_seleksi', 'seleksi.thn_akademik', 'beasiswa.nm_beasiswa', 'mahasiswa.npm');
    protected $column_search = array('seleksi.kd_seleksi', 'seleksi.thn_akademik', 'beasiswa.nm_beasiswa', 'mahasiswa.npm', 'mahasiswa.nama');
    protected $order = array('seleksi.nilai' => 'asc');
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
        $this->dt->select('seleksi.*, prodi.nm_prodi, mahasiswa.npm, mahasiswa.nama, beasiswa.nm_beasiswa')->join('prodi', 'prodi.id=seleksi.id_prodi', 'left')->join('mahasiswa', 'mahasiswa.id=seleksi.id_mahasiswa', 'left')->join('beasiswa', 'beasiswa.id=seleksi.id_beasiswa', 'left')->where('seleksi.deleted_at', NULL)->where('seleksi.id_prodi', session()->get('id_prodi'));
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
}
