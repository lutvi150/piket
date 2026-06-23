<?php

namespace App\Helpers;

class HariHelper
{
    /**
     * Ambil nama hari berdasarkan ID
     *
     * @param int $id
     * @return string
     */
    public static function getHari(int $id): string
    {
        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return $hari[$id] ?? '-';
    }

    /**
     * Ambil semua daftar hari
     *
     * @return array
     */
    public static function getAllHari(): array
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
    }
}