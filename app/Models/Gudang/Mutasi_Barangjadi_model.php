<?php

namespace App\Models\Gudang;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Mutasi_Barangjadi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'wh_mutasi_b_jadi';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['kodeitem', 'id_item', 'no_spp', 'tglspp_in', 'npb', 'kd_proses', 'satuan', 'qty', 'kgm', 'id_user', 'tgl_penyerahan', 'id_customer', 'created_at', 'updated_at'];

    protected $request;

    public function Allitem()
    {
        return $this->select('*')
            ->get()->getResultArray();
    }
}
