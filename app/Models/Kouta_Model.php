<?php
namespace App\Models;

use CodeIgniter\Model;


class Kouta_Model extends Model {
	
    protected $table = 'kouta';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['thn_akademik', 'id_beasiswa', 'id_prodi', 'kouta'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $column_order = array('kouta.id','kouta.thn_akademik', 'beasiswa.nm_beasiswa', 'prodi.nm_prodi');
    protected $column_search = array('kouta.thn_akademik', 'beasiswa.nm_beasiswa', 'prodi.nm_prodi');
    protected $order = array('kouta.id' => 'asc');
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

    private function _get_datatables_query(){
        $i = 0;
        $this->dt->select('kouta.*,beasiswa.nm_beasiswa,prodi.nm_prodi')->join('beasiswa', 'beasiswa.id=kouta.id_beasiswa', 'left')->join('prodi', 'prodi.id=kouta.id_prodi', 'left')->where('kouta.deleted_at', NULL);
        foreach ($this->column_search as $item){
            if($this->request->getPost('search')['value']){ 
                if($i===0){
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                }
                else{
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }
         
        if($this->request->getPost('order')){
                $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
            } 
        else if(isset($this->order)){
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables(){
        $this->_get_datatables_query();
        if($this->request->getPost('length') != -1)
        $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered(){
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all(){
        $tbl_storage = $this->db->table($this->table)->where('deleted_at', NULL);
        return $tbl_storage->countAllResults();
    }
}