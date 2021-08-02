<?php

namespace App\Models;

use CodeIgniter\Model;


class SeleksiDetail_Model extends Model
{

    protected $table = 'detail_seleksi';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['id_seleksi', 'id_mahasiswa', 'id_persyaratan', 'jawaban', 'bobot'];
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
