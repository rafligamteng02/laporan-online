<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanOnline extends Model
{
    use HasFactory;

    protected $table = 'laporan_onlines'; // atau nama tabel kamu di database

    protected $fillable = [
        'nama',
        'alamat',
        'deskripsi',
        'tanggal',
        'foto',
    ];
}
