<?php

namespace App\Libraries;

use CodeIgniter\Model;

class Service_Lib extends Model
{

    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->email = \Config\Services::email($this->config());
    }

    public function config()
    {
        $data =  [
            'protocol' => getenv('custome.email.protocol'),
            'SMTPHost' => getenv('custome.email.smtp.host'),
            'SMTPPort' => getenv('custome.email.smtp.port'),
            'SMTPTimeout' => getenv('custome.email.smtp.timeout'),
            'mailType' => getenv('custome.email.mail.type'),
            'userAgent' => getenv('custome.email.user.agent'),
            'SMTPUser' => getenv('custome.email.smtp.user'),
            'SMTPPass' => getenv('custome.email.smtp.password'),
            'newline' => '\r\n',
        ];
        return $data;
    }

    public function sendMail($data = null)
    {
        $to = $data['to'];
        $subject = $data['subject'];
        $message = $data['message'];

        $this->email->setTo($to);
        $this->email->setFrom(getenv('custome.email.from'), 'Layanan Internet');

        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllDataMahasiswa($id)
    {
        $qry = $this->db->table('mahasiswa')->where('id', $id)->get()->getRow();
        return $qry;
    }

    public function getAllDataSeleksi($id)
    {
        $qry = $this->db->table('seleksi')->where('id', $id)->get()->getRow();
        return $qry;
    }

    public function getNameProdi($id)
    {
        $nama = '';
        $qry = $this->db->table('prodi')->where('id', $id)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama = $key['nm_prodi'];
            }
        }

        return $nama;
    }

    public function getNameBeasiswa($id)
    {
        $nama = '';
        $qry = $this->db->table('beasiswa')->where('id', $id)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama = $key['nm_beasiswa'];
            }
        }

        return $nama;
    }

    public function getKoutaBeasiswa($thn_akademik, $id_beasiswa, $id_prodi)
    {
        $nama = [];
        $qry = $this->db->table('kouta')->where('thn_akademik', $thn_akademik)->where('id_beasiswa', $id_beasiswa)->where('id_prodi', $id_prodi)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama['kuota'] = $key['kouta'];
                $nama['id'] = $key['id'];
            }
        }

        return $nama;
    }

    public function getJawaban($id_seleksi, $id_persyaratan)
    {
        $nama = '';
        $qry = $this->db->table('detail_seleksi')->where('id_seleksi', $id_seleksi)->where('id_persyaratan', $id_persyaratan)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama = $key['jawaban'];
            }
        }

        return $nama;
    }

    public function getBobotPersyaratan($thn_akademik, $id_persyaratan)
    {
        $nama = '';
        $qry = $this->db->table('bobot')->where('id_persyaratan', $id_persyaratan)->where('thn_akademik', $thn_akademik)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama = $key['bobot'];
            }
        }

        return $nama;
    }

    public function perhitungan($thn_akademik, $id_beasiswa, $id_prodi, $id_kuota, $jumlah_kuota)
    {
        $data = array();
        $data2 = array();
        $total = array();
        $qry = $this->db->table('seleksi')->where('thn_akademik', $thn_akademik)->where('id_beasiswa', $id_beasiswa)->where('id_prodi', $id_prodi)->where('deleted_at is null')->get()->getResultArray();

        if ($qry) {
            $no = 0;

            foreach ($qry as $row) {
                $qry2 = $this->db->table('detail_seleksi')->where('id_seleksi', $row['id'])->where('id_mahasiswa', $row['id_mahasiswa'])->get()->getResultArray();

                if (!$qry2) {
                    continue;
                } else {
                    foreach ($qry2 as $row2) {
                        $data2[$no][] = (int) $row2['bobot'] * (int)$row2['jawaban'];
                    }

                    $nilai = array_sum($data2[$no]);
                    $pangkat = pow(10, strlen($nilai));
                    $hasil = $nilai / $pangkat;

                    array_push($data, array('id_mahasiswa' => $row['id_mahasiswa'], 'id_seleksi' => $row['id'], 'nilai' => $hasil));

                    $this->db->table('seleksi')->where('id', $row['id'])->set(['nilai' => $hasil])->update();
                    $no++;
                }
            }
            if ($data) {
                $dtSeleksi = $this->db->table('seleksi')->select('id')->where('id_kouta', $id_kuota)->where('nilai is not null')->orderBy('nilai', 'DESC')->get()->getResultArray();

                for ($i = 0; $i < count($dtSeleksi); $i++) {
                    $status = $i <= ($jumlah_kuota - 1) ? 'Layak' : 'Tidak Layak';

                    $this->db->table('seleksi')->where('id', $dtSeleksi[$i]['id'])->set(['status_terima' => $status])->update();
                }

                // $jmlhKuotaBaru = $jumlah_kuota >= count($dtSeleksi) ? $jumlah_kuota - count($dtSeleksi) : 0;

                // $this->db->table('kouta')->where('id', $id_kuota)->set(['kouta' => $jmlhKuotaBaru])->update();

                return $data;
            }
            session()->setFlashdata('errors', 'Data Detail Seleksi Masih kosong. Isi Data Terlebih Dahulu');
            return null;
        } else {
            session()->setFlashdata('errors', 'Data Seleksi Masih kosong. Isi Data Terlebih Dahulu');
            return null;
        }
    }
}
