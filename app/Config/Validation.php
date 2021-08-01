<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $loginUser = [
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required'
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required'
        ]
    ];

    public $loginUser_errors = [
        'username' => [
            'required' => '{field} wajib diisi'
        ],
        'password' => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $updatePassword = [
        'password_lama'       => [
            'label'  => 'Password Lama',
            'rules'  => 'required'
        ],
        'password_baru'       => [
            'label'  => 'Password Baru',
            'rules'  => 'required'
        ],
        'confirm_password_baru'       => [
            'label'  => 'Ulang Password Baru',
            'rules'  => 'required|matches[password_baru]'
        ]
    ];

    public $updatePassword_errors = [
        'password_lama'       => [
            'required' => '{field} wajib diisi'
        ],
        'password_baru'       => [
            'required' => '{field} wajib diisi'
        ],
        'confirm_password_baru'      => [
            'required' => '{field} wajib diisi',
            'matches'  => 'Password tidak cocok'
        ]
    ];

    public $insertProdi = [
        'kd_prodi'       => [
            'label'  => 'Kode Prodi',
            'rules'  => 'required|is_unique[prodi.kd_prodi]'
        ],
        'nm_prodi'       => [
            'label'  => 'Nama Prodi',
            'rules'  => 'required'
        ]
    ];

    public $insertProdi_errors = [
        'kd_prodi'       => [
            'required' => '{field} wajib diisi',
            'is_unique' => '{field} sudah ada di database'
        ],
        'nm_prodi'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $updateProdi = [
        'kd_prodi'       => [
            'label'  => 'Kode Prodi',
            'rules'  => 'required'
        ],
        'nm_prodi'       => [
            'label'  => 'Nama Prodi',
            'rules'  => 'required'
        ]
    ];

    public $updateProdi_errors = [
        'kd_prodi'       => [
            'required' => '{field} wajib diisi'
        ],
        'nm_prodi'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertMahasiswa = [
        'npm'       => [
            'label'  => 'NPM',
            'rules'  => 'required|is_unique[mahasiswa.npm]'
        ],
        'nama'       => [
            'label'  => 'Nama',
            'rules'  => 'required'
        ],
        'jk'       => [
            'label'  => 'Jenis Kelamin',
            'rules'  => 'required'
        ],
        'umur'       => [
            'label'  => 'Umur',
            'rules'  => 'required'
        ],
        'asal_slta'       => [
            'label'  => 'Asal SLTA',
            'rules'  => 'required'
        ],
        'jurusan_slta'       => [
            'label'  => 'Jurusan SLTA',
            'rules'  => 'required'
        ],
        'thn_lulus'       => [
            'label'  => 'Tahun Lulus',
            'rules'  => 'required'
        ],
        'id_prodi'       => [
            'label'  => 'Prodi',
            'rules'  => 'required'
        ]
    ];

    public $insertMahasiswa_errors = [
        'npm'       => [
            'required' => '{field} wajib diisi',
            'is_unique' => '{field} sudah ada di database'
        ],
        'nama'       => [
            'required' => '{field} wajib diisi'
        ],
        'jk'       => [
            'required' => '{field} wajib diisi'
        ],
        'umur'       => [
            'required' => '{field} wajib diisi'
        ],
        'asal_slta'       => [
            'required' => '{field} wajib diisi'
        ],
        'jurusan_slta'       => [
            'required' => '{field} wajib diisi'
        ],
        'thn_lulus'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_prodi'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $updateMahasiswa = [
        'npm'       => [
            'label'  => 'NPM',
            'rules'  => 'required'
        ],
        'nama'       => [
            'label'  => 'Nama',
            'rules'  => 'required'
        ],
        'jk'       => [
            'label'  => 'Jenis Kelamin',
            'rules'  => 'required'
        ],
        'umur'       => [
            'label'  => 'Umur',
            'rules'  => 'required'
        ],
        'asal_slta'       => [
            'label'  => 'Asal SLTA',
            'rules'  => 'required'
        ],
        'jurusan_slta'       => [
            'label'  => 'Jurusan SLTA',
            'rules'  => 'required'
        ],
        'thn_lulus'       => [
            'label'  => 'Tahun Lulus',
            'rules'  => 'required'
        ],
        'id_prodi'       => [
            'label'  => 'Prodi',
            'rules'  => 'required'
        ]
    ];

    public $updateMahasiswa_errors = [
        'npm'       => [
            'required' => '{field} wajib diisi'
        ],
        'nama'       => [
            'required' => '{field} wajib diisi'
        ],
        'jk'       => [
            'required' => '{field} wajib diisi'
        ],
        'umur'       => [
            'required' => '{field} wajib diisi'
        ],
        'asal_slta'       => [
            'required' => '{field} wajib diisi'
        ],
        'jurusan_slta'       => [
            'required' => '{field} wajib diisi'
        ],
        'thn_lulus'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_prodi'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertBeasiswa = [
        'kd_beasiswa'       => [
            'label'  => 'Kode Beasiswa',
            'rules'  => 'required|is_unique[mahasiswa.npm]'
        ],
        'nm_beasiswa'       => [
            'label'  => 'Nama Beasiswa',
            'rules'  => 'required'
        ],
        'sumber'       => [
            'label'  => 'Sumber',
            'rules'  => 'required'
        ],
        'jumlah'       => [
            'label'  => 'Jumlah',
            'rules'  => 'required'
        ]
    ];

    public $insertBeasiswa_errors = [
        'kd_beasiswa'       => [
            'required' => '{field} wajib diisi',
            'is_unique' => '{field} sudah ada di database'
        ],
        'nm_beasiswa'       => [
            'required' => '{field} wajib diisi'
        ],
        'sumber'       => [
            'required' => '{field} wajib diisi'
        ],
        'jumlah'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertKouta = [
        'thn_akademik'       => [
            'label'  => 'Tahun Akademik',
            'rules'  => 'required'
        ],
        'id_beasiswa'       => [
            'label'  => 'Beasiswa',
            'rules'  => 'required'
        ],
        'id_prodi'       => [
            'label'  => 'Prodi',
            'rules'  => 'required'
        ],
        'kouta'       => [
            'label'  => 'Kouta',
            'rules'  => 'required'
        ]
    ];

    public $insertKouta_errors = [
        'thn_akademik'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_beasiswa'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_prodi'       => [
            'required' => '{field} wajib diisi'
        ],
        'kouta'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertPersyaratan = [
        'kd_persyaratan'       => [
            'label'  => 'Kode Persyaratan',
            'rules'  => 'required'
        ],
        'nm_persyaratan'       => [
            'label'  => 'Nama Persyaratan',
            'rules'  => 'required'
        ],
        'id_beasiswa'       => [
            'label'  => 'Beasiswa',
            'rules'  => 'required'
        ],
        'type_persyaratan'       => [
            'label'  => 'Tipe Persyaratan',
            'rules'  => 'required'
        ]
    ];

    public $insertPersyaratan_errors = [
        'kd_persyaratan'       => [
            'required' => '{field} wajib diisi'
        ],
        'nm_persyaratan'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_beasiswa'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertBobot = [
        'thn_akademik'       => [
            'label'  => 'Tahun Akademik',
            'rules'  => 'required'
        ],
        'id_persyaratan'       => [
            'label'  => 'Persyaratan',
            'rules'  => 'required'
        ],
        'bobot'       => [
            'label'  => 'Bobot',
            'rules'  => 'required'
        ]
    ];

    public $insertBobot_errors = [
        'thn_akademik'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_persyaratan'       => [
            'required' => '{field} wajib diisi'
        ],
        'bobot'       => [
            'required' => '{field} wajib diisi'
        ]
    ];

    public $insertSeleksi = [
        'kd_seleksi'       => [
            'label'  => 'Kode Seleksi',
            'rules'  => 'required'
        ],
        'thn_akademik'       => [
            'label'  => 'Tahun Akademik',
            'rules'  => 'required'
        ],
        'id_beasiswa'       => [
            'label'  => ' Beasiswa',
            'rules'  => 'required'
        ],
        'id_mahasiswa'       => [
            'label'  => 'Mahasiswa',
            'rules'  => 'required'
        ],
        'tgl_seleksi'       => [
            'label'  => 'Tanggal Seleksi',
            'rules'  => 'required'
        ]
    ];

    public $insertSeleksi_errors = [
        'kd_seleksi'       => [
            'required' => '{field} wajib diisi'
        ],
        'thn_akademik'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_beasiswa'       => [
            'required' => '{field} wajib diisi'
        ],
        'id_mahasiswa'       => [
            'required' => '{field} wajib diisi'
        ],
        'tgl_seleksi'       => [
            'required' => '{field} wajib diisi'
        ]
    ];
}
