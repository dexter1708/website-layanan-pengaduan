<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        // Kecamatan Andir
        $this->insertWilayah(1, 1, ['Campaka', 'Ciroyom', 'Dunguscariang', 'Garuda', 'Kebonjeruk', 'Maleber']);

        // Kecamatan Astana Anyar
        $this->insertWilayah(1, 2, ['Cibadak', 'Karanganyar', 'Karasak', 'Nyengseret', 'Panjunan', 'Pelindunghewan']);

        // Kecamatan Antapani
        $this->insertWilayah(1, 3, ['Antapani Kidul', 'Antapani Kulon', 'Antapani Tengah', 'Antapani Wetan']);

        // Kecamatan Arcamanik
        $this->insertWilayah(1, 4, ['Cisaranten Bina Harapan', 'Cisaranten Endah', 'Cisaranten Kulon', 'Sukamiskin']);

        // Kecamatan Babakan Ciparay
        $this->insertWilayah(1, 5, ['Babakan', 'Babakanciparay', 'Cirangrang', 'Margahayu Utara', 'Margasuka', 'Sukahaji']);

        // Kecamatan Bandung Kidul
        $this->insertWilayah(1, 6, ['Batununggal', 'Kujangsari', 'Mengger', 'Wates']);

        // Kecamatan Bandung Kulon
        $this->insertWilayah(1, 7, ['Caringin', 'Cibuntu', 'Cigondewah Kaler', 'Cigondewah Kidul', 'Cigondewah Rahayu', 'Cijerah', 'Gempolsari', 'Warungmuncang']);

        // Kecamatan Bandung Wetan
        $this->insertWilayah(1, 8, ['Cihapit', 'Citarum', 'Tamansari']);

        // Kecamatan Batununggal
        $this->insertWilayah(1, 9, ['Binong', 'Cibangkong', 'Gumuruh', 'Kacapiring', 'Kebongedang', 'Kebonwaru', 'Maleer', 'Samoja']);

        // Kecamatan Bojongloa Kaler
        $this->insertWilayah(1, 10, ['Babakan Asih', 'Babakan Tarogong', 'Jamika', 'Kopo', 'Suka Asih']);

        // Kecamatan Bojongloa Kidul
        $this->insertWilayah(1, 11, ['Cibaduyut', 'Cibaduyut Kidul', 'Cibaduyut Wetan', 'Kebon Lega', 'Mekarwangi', 'Situsaeur']);

        // Kecamatan Buahbatu
        $this->insertWilayah(1, 12, ['Cijawura', 'Jatisari', 'Margasari', 'Sekejati']);

        // Kecamatan Cibeunying Kaler
        $this->insertWilayah(1, 13, ['Cigadung', 'Cihaurgeulis', 'Neglasari', 'Sukaluyu']);

        // Kecamatan Cibeunying Kidul
        $this->insertWilayah(1, 14, ['Cicadas', 'Cikutra', 'Padasuka', 'Pasirlayung', 'Sukamaju', 'Sukapada']);

        // Kecamatan Ciberu
        $this->insertWilayah(1, 15, ['Cipadung', 'Cisurupan', 'Palasari', 'Pasirbiru']);

        // Kecamatan Cicendo
        $this->insertWilayah(1, 16, ['Arjuna', 'Husen Sastranegara', 'Pajajaran', 'Pamoyanan', 'Pasirkaliki', 'Sukaraja']);

        // Kecamatan Cidadap
        $this->insertWilayah(1, 17, ['Ciumbuleuit', 'Hegarmanah', 'Ledeng']);

        // Kecamatan Cinambo
        $this->insertWilayah(1, 18, ['Babakan Penghulu', 'Cisaranten Wetan', 'Pakemitan', 'Sukamulya']);

        // Kecamatan Coblong
        $this->insertWilayah(1, 19, ['Cipaganti', 'Dago', 'Lebakgede', 'Lebaksiliwangi', 'Sadangserang', 'Sekeloa']);

        // Kecamatan Gedebage
        $this->insertWilayah(1, 20, ['Cimincrang', 'Cisaranten Kidul', 'Rancabolang', 'Rancanumpang']);

        // Kecamatan Kiaracondong
        $this->insertWilayah(1, 21, ['Babakansari', 'Babakansurabaya', 'Cicaheum', 'Kebonkangkung', 'Kebunjayanti', 'Sukapura']);

        // Kecamatan Lengkong
        $this->insertWilayah(1, 22, ['Burangrang', 'Cijagra', 'Cikawao', 'Lingkar Selatan', 'Malabar', 'Paladang', 'Turangga']);

        // Kecamatan Mandalajati
        $this->insertWilayah(1, 23, ['Jatihandap', 'Karangpamulang', 'Pasir Impun', 'Sindangjaya']);

        // Kecamatan Panyileukan
        $this->insertWilayah(1, 24, ['Cipadung Kidul', 'Cipadung Kulon', 'Cipadung Wetan', 'Mekarmulya']);

        // Kecamatan Rancasari
        $this->insertWilayah(1, 25, ['Cipamokolan', 'Darwati', 'Manjahlega', 'Mekar Jaya']);

        // Kecamatan Regol
        $this->insertWilayah(1, 26, ['Ancol', 'Balonggede', 'Ciateul', 'Cigereleng', 'Ciseureuh', 'Pasirluyu', 'Pungkur']);

        // Kecamatan Sukajadi
        $this->insertWilayah(1, 27, ['Cipedes', 'Pasteur', 'Sukabungah', 'Sukagalih', 'Sukawarna']);

        // Kecamatan Sukasari
        $this->insertWilayah(1, 28, ['Gegerkalong', 'Isola', 'Sarijadi', 'Sukarasa']);

        // Kecamatan Sumur Bandung
        $this->insertWilayah(1, 29, ['Babakanciamis', 'Braga', 'Kebonpisang', 'Merdeka']);

        // Kecamatan Ujungberung
        $this->insertWilayah(1, 30, ['Cigending', 'Pasanggrahan', 'Pasirendah', 'Pasirjati', 'Pasirwangi']);
    }

    private function insertWilayah($kotaId, $kecamatanId, $desas)
    {
        foreach ($desas as $desa) {
            DB::table('wilayah')->insert([
                'kota_id' => $kotaId,
                'kecamatan_id' => $kecamatanId,
                'desa_id' => null, 
                'kota_nama' => 'Bandung',
                'kecamatan_nama' => $this->getKecamatanName($kecamatanId),
                'desa_nama' => $desa,
            ]);
        }
    }

    private function getKecamatanName($kecamatanId)
    {
        $kecamatanNames = [
            1 => 'Andir',
            2 => 'Astana Anyar',
            3 => 'Antapani',
            4 => 'Arcamanik',
            5 => 'Babakan Ciparay',
            6 => 'Bandung Kidul',
            7 => 'Bandung Kulon',
            8 => 'Bandung Wetan',
            9 => 'Batununggal',
            10 => 'Bojongloa Kaler',
            11 => 'Bojongloa Kidul',
            12 => 'Buahbatu',
            13 => 'Cibeunying Kaler',
            14 => 'Cibeunying Kidul',
            15 => 'Ciberu',
            16 => 'Cicendo',
            17 => 'Cidadap',
            18 => 'Cinambo',
            19 => 'Coblong',
            20 => 'Gedebage',
            21 => 'Kiaracondong',
            22 => 'Lengkong',
            23 => 'Mandalajati',
            24 => 'Panyileukan',
            25 => 'Rancasari',
            26 => 'Regol',
            27 => 'Sukajadi',
            28 => 'Sukasari',
            29 => 'Sumur Bandung',
            30 => 'Ujungberung',
        ];

        return $kecamatanNames[$kecamatanId];
    }
}
