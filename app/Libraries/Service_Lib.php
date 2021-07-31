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
        $nama = '';
        $qry = $this->db->table('kouta')->where('thn_akademik', $thn_akademik)->where('id_beasiswa', $id_beasiswa)->where('id_prodi', $id_prodi)->get()->getResultArray();
        if (count($qry) > 0) {
            foreach ($qry as $key) {
                $nama = $key['kouta'];
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

    public function perhitungan($thn_akademik, $id_beasiswa, $id_prodi)
    {
        $data = array();
        $data2 = array();
        $total = array();
        $qry = $this->db->table('seleksi')->where('thn_akademik', $thn_akademik)->where('id_beasiswa', $id_beasiswa)->where('id_prodi', $id_prodi)->get()->getResultArray();
        $no = 0;
        foreach ($qry as $row) {
            $qry2 = $this->db->table('detail_seleksi')->where('id_seleksi', $row['id'])->where('id_mahasiswa', $row['id_mahasiswa'])->get()->getResultArray();
            foreach ($qry2 as $row2) {
                $data2[$no][] = $row2['bobot'] * $row2['jawaban'];
            }

            $nilai = array_sum($data2[$no]);
            $pangkat = pow(10, strlen($nilai));
            $hasil = $nilai / $pangkat;

            array_push($data, array('id_mahasiswa' => $row['id_mahasiswa'], 'id_seleksi' => $row['id'], 'nilai' => $hasil));
            $this->db->table('seleksi')->where('id', $row['id'])->set(['nilai' => $hasil])->update();
            $no++;
        }
        return $data;
    }
}
