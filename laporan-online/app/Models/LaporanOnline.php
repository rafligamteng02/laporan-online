<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanOnline extends Model
{
    use HasFactory;

    protected $table = 'laporan_onlines'; // atau 'laporans' jika itu nama tabel kamu

    protected $fillable = [
        'nama',
        'alamat',
        'deskripsi',
        'tanggal',
        'foto',
        'status',
    ];
}
