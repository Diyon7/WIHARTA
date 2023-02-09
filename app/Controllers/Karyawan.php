<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Pendidikan_model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;
use App\Models\Group_model;
use Config\Services;
use App\Models\Logkaryawan_model;

class Karyawan extends BaseController
{

    protected $pegawaimodel;
    protected $jabatan;
    protected $pendidikan;
    protected $divisi;
    protected $unitmodel;
    protected $group;
    protected $subunit;
    protected $vendormodel;

    public function __construct()
    {
        $this->pegawaimodel = new Pegawai_Model();
        $this->jabatan = new Jabatan_model();
        $this->group = new Group_model();
        $this->pendidikan = new Pendidikan_model();
        $this->divisi = new Divisi_model();
        $this->unitmodel = new Unit_model();
        $this->subunit = new Subunit_model();
        $this->vendormodel = new Vendor_model();
    }

    public function Index()
    {
        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Karyawan',
        ];

        return view('karyawan/index', $data);
    }

    public function Add()
    {
        helper('form');

        $vendor = $this->vendormodel->findAll();
        $jabatan = $this->jabatan->findAll();
        $divisi = $this->divisi->findAll();
        $unit = $this->unitmodel->findAll();
        $subunit = $this->subunit->findAll();

        $data = [
            'vendor' => $vendor,
            'jabatan' => $jabatan,
            'divisi' => $divisi,
            'unit' => $unit,
            'subunit' => $subunit,
        ];

        return view('karyawan/tambahpegawai', $data);
    }

    public function Detailakaryawanjp3()
    {
        if ($this->request->isAJAX()) {
            $nippegaw = $this->request->getPost('idnip');

            $detailkarya = $this->pegawaimodel->Detailkaryawana($nippegaw);

            $data = [
                'detailkaryawana' => $detailkarya
            ];
            $msg = [
                'sukses' => view('karyawan/detail', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Pembagian()
    {
        if ($this->request->isAJAX()) {
            $subunit = $this->request->getPost('subunit');

            $all = $this->pegawaimodel->Pda_Pegawai($subunit);

            $msg = [
                'namadivisi' => $all['namadivisi'],
                'pembagian2id' => $all['pembagian2id'],
                'namaunit' => $all['namaunit'],
                'pembagian4id' => $all['pembagian4id'],
                'namasubunit' => $all['namasubunit'],
                'pembagian5id' => $all['pembagian5id']
            ];

            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $pend = $this->pendidikan->findAll();
            $vendor = $this->vendormodel->findAll();
            $grupt = $this->pegawaimodel->Groupt();
            $golongan = $this->pegawaimodel->Golongan();
            $jabatan = $this->jabatan->findAll();
            $divisi = $this->divisi->findAll();
            $unit = $this->unitmodel->findAll();
            $subunit = $this->subunit->findAll();

            $nippegaw = $this->request->getPost('idnip');


            $editkarya = $this->pegawaimodel->Edit($nippegaw);

            $data = [
                'editkaryawanall' => $editkarya,
                'vendor' => $vendor,
                'golongan' => $golongan,
                'pend' => $pend,
                'jabatan' => $jabatan,
                'grup_t' => $grupt,
                'divisi' => $divisi,
                'unit' => $unit,
                'subunit' => $subunit,
                'nip' => $nippegaw
            ];
            $msg = [
                'sukses' => view('karyawan/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Save()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'asal' => [
                        'label'  => 'asal',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Asal harus dipilih !',
                        ],
                    ],
                    'nama' => [
                        'label'  => 'nama',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'nama harus diisi',
                        ],
                    ],
                    'jk' => [
                        'label'  => 'jk',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Jenis kelamin harus dipilih !',
                        ],
                    ],
                    // 'pendidikan' => [
                    //     'label'  => 'pendidikan',
                    //     'rules'  => 'required',
                    //     'errors' => [
                    //         'required' => 'Pendidikan harus dipilih !',
                    //     ],
                    // ],
                    'divisi' => [
                        'label'  => 'divisi',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Divisi harus dipilih !',
                        ],
                    ],
                    'unit' => [
                        'label'  => 'unit',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Unit harus dipilih !',
                        ],
                    ],
                    'subunit' => [
                        'label'  => 'subunit',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Sub Unit harus dipilih !',
                        ],
                    ],
                    'grup_t' => [
                        'label'  => 'grup_t',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Grup harus dipilih !',
                        ],
                    ],
                    'tmt' => [
                        'label'  => 'tmt',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tmt harus dipilih !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $asal = htmlspecialchars($this->request->getPost('asal'));
                    $nip = $this->request->getPost('nip');
                    $nama = htmlspecialchars($this->request->getPost('nama'));
                    $tgllahir = htmlspecialchars($this->request->getPost('tgllahir'));
                    $jk = htmlspecialchars($this->request->getPost('jk'));
                    $telepon = htmlspecialchars($this->request->getPost('telepon'));
                    $alamat = htmlspecialchars($this->request->getPost('alamat'));
                    $pendidikan = htmlspecialchars($this->request->getPost('pendidikan'));
                    $divisi = htmlspecialchars($this->request->getPost('divisi'));
                    $unit = htmlspecialchars($this->request->getPost('unit'));
                    $subunit = htmlspecialchars($this->request->getPost('subunit'));
                    $grup_t = htmlspecialchars($this->request->getPost('grup_t'));
                    $jabatan = htmlspecialchars($this->request->getPost('jabatan'));
                    $golongan = htmlspecialchars($this->request->getPost('golongan'));
                    $tmt = htmlspecialchars($this->request->getPost('tmt'));

                    $groupall = $this->group->where('group_k', $grup_t)->first();

                    $pegawai = [
                        'pembagian3_id' => $asal,
                        'pegawai_nama' => $nama,
                        'tgl_lahir' => $tgllahir,
                        'gender' => $jk,
                        'pegawai_telp' => $telepon,
                        'pembagian2_id' => $divisi,
                        'pembagian4_id' => $unit,
                        'pembagian5_id' => $subunit,
                        'grup' => $groupall['group'],
                        'grup_t' => $groupall['group_k'],
                        'grup_jam_kerja' => $groupall['group_jk'],
                        'pembagian1_id' => $jabatan,
                        'golongan' => $golongan,
                        'tgl_mulai_kerja' => $tmt,
                        'tgl_masuk_pertama' => $tmt
                    ];

                    $dataupdate = $this->pegawaimodel->where('pegawai_nip', $nip)->set($pegawai)->update();

                    if ($dataupdate) {
                        session()->setFlashdata('success', 'Edit karyawan berhasil');
                        $msg = [
                            'success' => 'data sukses diedit'
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
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->unit;
                $row[] = $karyawana->tmt;
                $row[] = $karyawana->grup_t;
                $row[] = "<a onclick=\"detailkaryawana('$karyawana->idkar')\" class=\"btn btn-xs btn-outline-success\">Detail</a><a class=\"btn-xs btn-edit btn btn-outline-success\" data-editkarid=\"$karyawana->idkar\">Edit</a><a class=\"btn-xs btn-keluar btn btn-outline-success\" data-keluarid=\"$karyawana->idkar\">Keluar</a>";
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
                $row[] = "<button class=\"btn btn-success\">Detail</button>";
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
            'halaman' => 'Karyawan'
        ];

        return view('karyawan/logkaryawan', $data);
    }
}