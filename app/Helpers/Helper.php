<?php

if (!function_exists('tanggal')) {
    function tanggal($tgl)
    {
        $ex = explode(' ', $tgl);
        $tanggal = substr($ex[0], 8, 2);
        $bulan = bulan(substr($ex[0], 5, 2));
        $tahun = substr($ex[0], 0, 4);
        return nama_hari($ex[0]) . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $ex[1];
    }
}

if (!function_exists('tanggalDate')) {
    function tanggalDate($tgl)
    {
        $ex = explode(' ', $tgl);
        $tanggal = substr($ex[0], 8, 2);
        $bulan = bulan(substr($ex[0], 5, 2));
        $tahun = substr($ex[0], 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if (!function_exists('nama_hari')) {
    function nama_hari($tanggal)
    {
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];

        $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari;
    }
}

if (!function_exists('hitung_mundur')) {
    function hitung_mundur($wkt)
    {
        $waktu = array(
            365 * 24 * 60 * 60 => "tahun",
            30 * 24 * 60 * 60 => "bulan",
            7 * 24 * 60 * 60 => "minggu",
            24 * 60 * 60 => "hari",
            60 * 60 => "jam",
            60 => "menit",
            1 => "detik",
        );

        $hitung = strtotime(gmdate("Y-m-d H:i:s", time() + 60 * 60 * 8)) - $wkt;
        $hasil = array();
        if ($hitung < 5) {
            $hasil = 'kurang dari 5 detik yang lalu';
        } else {
            $stop = 0;
            foreach ($waktu as $periode => $satuan) {
                if ($stop >= 6 || ($stop > 0 && $periode < 60)) {
                    break;
                }

                $bagi = floor($hitung / $periode);
                if ($bagi > 0) {
                    $hasil[] = $bagi . ' ' . $satuan;
                    $hitung -= $bagi * $periode;
                    $stop++;
                } else if ($stop > 0) {
                    $stop++;
                }
            }
            $hasil = implode(' ', $hasil) . ' yang lalu';
        }
        return $hasil;
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka, $withRp = true)
    {
        // Pastikan $angka adalah angka yang valid (float atau integer)
        $angka = is_numeric($angka) ? floatval($angka) : 0;

        if ($angka == 0) {
            return 'Rp -';
        }

        // Format angka ke dalam format mata uang
        $hasil_rupiah = ($withRp ? "Rp " : "") . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}


if (!function_exists('hp')) {
    function hp($nohp)
    {
        $hp = $nohp;
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            }
        }
        return $hp;
    }
}

if (!function_exists('distance')) {
    function distance($lat1, $lng1, $lat2, $lng2)
    {
        $theta = $lng1 - $lng2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
    }
}

if (!function_exists('searchForKey')) {
    function searchForKey(string $id, array $array, $value)
    {
        foreach ($array as $key => $val) {
            if ($val[$id] == $value) {
                return $key;
            }
        }
        return null;
    }
}
