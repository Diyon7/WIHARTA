<?php

namespace App\Controllers\Gudang;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Pendidikan_model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\Gudang\Item_ccn_model;
use App\Models\Gudang\Customer_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;
use App\Models\Group_model;
use App\Models\Diliburkan_model;
use Config\Services;
use App\Models\Logkaryawan_model;

class Produksi extends BaseController
{

    protected $pegawaimodel;
    protected $jabatan;
    protected $pendidikan;
    protected $divisi;
    protected $unitmodel;
    protected $diliburkan;
    protected $group;
    protected $customer;
    protected $subunit;
    protected $item;
    protected $vendormodel;
    protected $encrypter;

    public function __construct()
    {

        $this->pegawaimodel = new Pegawai_Model();
        $this->jabatan = new Jabatan_model();
        $this->group = new Group_model();
        $this->item = new item_ccn_model();
        $this->customer = new Customer_model();
        $this->pendidikan = new Pendidikan_model();
        $this->divisi = new Divisi_model();
        $this->unitmodel = new Unit_model();
        $this->diliburkan = new Diliburkan_model();
        $this->subunit = new Subunit_model();
        $this->vendormodel = new Vendor_model();
    }

    public function Index()
    {
        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Karyawan'
        ];

        return view('karyawan/index', $data);
    }

    public function InputMutasiPenerimaanBarangJadi()
    {
        helper('form');
        $idata = "";

        // $dataitem = $this->item->Allitem($idata);

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Gudang',
            // 'item' => $dataitem,
            'halaman' => 'Gudang',
        ];

        return view('gudang/formmutasipenerimaanbarangjadi', $data);
    }

    public function Searchitem()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $dataitem = $this->item->Allitem($idata);

            // $data = [
            //     'item' => $dataitem
            // ];

            echo json_encode($dataitem);
        }
    }

    public function Namaitem()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $kodeitem = $this->request->getPost("kodeitem");

            $dataitem = $this->item->Namaitem($kodeitem);

            $data = [
                'namaitem' => $dataitem['item_description']
            ];

            echo json_encode($data);
        }
    }

    public function Customername()
    {
        if ($this->request->isAJAX()) {

            helper('form');

            $customernama = $this->request->getVar("search");

            $dataitem = $this->customer->Allcustomer($customernama);

            echo json_encode($dataitem);
        }
    }

    public function Customeraddr()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $namacustomer = $this->request->getPost("namacustomer");

            $datacustomeraddr = $this->customer->Addrcustomer($namacustomer);

            $data = [
                'customeraddr' => $datacustomeraddr['customer_addr1']
            ];

            echo json_encode($data);
        }
    }

    public function Keluar()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tglresign' => [
                        'label'  => 'tglresign',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus dipilih !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $tgl = htmlspecialchars($this->request->getPost('tglresign'));
                    $nip = $this->request->getPost('iidkar');

                    $pegawai = [
                        'tgl_resign' => $tgl,
                        'resign' => '1'
                    ];

                    $dataupdate = $this->pegawaimodel->where('pegawai_nip', $nip)->set($pegawai)->update();

                    if ($dataupdate) {
                        $msg = [
                            'success' => 'karyawan keluar'
                        ];
                    } else {
                        $msg = [
                            'error' => 'data error'
                        ];
                    }
                } else {
                    $msg = [
                        'error' => $this->validator->listErrors()
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function Adddiliburkan()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tgl' => [
                        'label'  => 'tgl',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus dipilih !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $tgl = htmlspecialchars($this->request->getPost('tgl'));
                    $unit = $this->request->getPost('unit');
                    $jorang = $this->request->getPost('jorang');

                    $pegawai = [
                        'tgl' => $tgl,
                        'pembagian4_id' => $unit,
                        'jumlah_orang' => $jorang
                    ];

                    $save = $this->diliburkan->insert($pegawai);

                    if ($save) {
                        $msg = [
                            'success' => 'berhasil'
                        ];
                    } else {
                        $msg = [
                            'error' => 'data error'
                        ];
                    }
                } else {
                    $msg = [
                        'error' => $this->validator->listErrors()
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function Deletediliburkan()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $iddiliburkan = htmlspecialchars($this->request->getPost('iddiliburkan'));

            if ($iddiliburkan) {
                $delete = $this->diliburkan->delete($iddiliburkan);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Datatablesdiliburkan()
    {
        $request = Services::request();
        $diliburkan = new Diliburkan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $diliburkan->get_datatablesdiliburkan();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $dkaryawan) {
                $no++;
                $row = [];
                $row[] = $dkaryawan->tgl;
                $row[] = $dkaryawan->unit;
                $row[] = $dkaryawan->jumlah_orang;
                $row[] = "<a class=\"btn btn-danger btn-delete btn-sm\" data-deletediliburkan=\"$dkaryawan->iddiliburkan\">Delete</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $diliburkan->count_alldiliburkan(),
                "recordsFiltered" => $diliburkan->count_filtereddiliburkan(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesjp3a()
    {
        $request = Services::request();
        $pegawaimodel = new Pegawai_Model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $pegawaimodel->get_datatableskaryawanajp3();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $karyawana) {
                $no++;
                $edetail = $this->encrypter->encrypt($karyawana->idkar);
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->unit;
                $row[] = $karyawana->tmt;
                $row[] = $karyawana->grup_t;
                $row[] = "<a href='" . base_url() . "/admin/karyawan/detail/" . base64_encode($karyawana->idkar) . "' class=\"btn btn-xs btn-outline-success\">Detail</a><a class=\"btn-xs btn-keluar btn btn-outline-success\" data-keluarid=\"$karyawana->idkar\">Keluar</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $pegawaimodel->count_allkaryawanajp3(),
                "recordsFiltered" => $pegawaimodel->count_filteredkaryawanajp3(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatableslogkaryawan()
    {
        $request = Services::request();
        $logkaryawan = new Logkaryawan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $logkaryawan->get_datatableskaryawanajp3();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $karyawana) {
                $no++;
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->scandate;
                $row[] = $karyawana->inouttype;
                $row[] = $karyawana->pin;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $logkaryawan->count_allkaryawanajp3(),
                "recordsFiltered" => $logkaryawan->count_filteredkaryawanajp3(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    public function Datatablesjp3k()
    {
        $request = Services::request();
        $pegawaimodel = new Pegawai_Model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $pegawaimodel->get_datatableskaryawankjp3();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $karyawana) {
                $no++;
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->tmt;
                $row[] = $karyawana->tgl_resign;
                $row[] = "<button class=\"btn btn-success\"></button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $pegawaimodel->count_allkaryawankjp3(),
                "recordsFiltered" => $pegawaimodel->count_filteredkaryawankjp3(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Logkaryawan()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Log Karyawan'
        ];

        return view('karyawan/logkaryawan', $data);
    }
}
