<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Diliburkan_model extends Model
{
    protected $table      = 'diliburkan';
    protected $primaryKey = 'id_diliburkan';

    protected $allowedFields = ['tgl', 'jumlah_orang', 'pembagian4_id', 'id_diliburkan'];

    protected $skipValidation     = false;

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function _get_datatables_querydiliburkan()
    {
        $column_order = array('tgl', 'jumlah_orang', 'pembagian4.pembagian4_nama');
        $column_search = array('tgl', 'jumlah_orang', 'pembagian4.pembagian4_nama');
        $order = array('tgl' => 'desc');

        $this->select("tgl AS tgl, jumlah_orang AS jumlah_orang, pembagian4.pembagian4_nama AS unit");
        $this->join('pembagian4', 'pembagian4.pembagian4_id=diliburkan.pembagian4_id');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesdiliburkan()
    {
        $this->_get_datatables_querydiliburkan();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filtereddiliburkan()
    {
        $this->_get_datatables_querydiliburkan();
        return $this->countAllResults();
    }

    public function count_alldiliburkan()
    {
        $this->select("tgl, jumlah_orang, pembagian4_id");
        return $this->countAllResults();
    }
}
