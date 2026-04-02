<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SanggarProfile extends Model {
    protected $table = 'sanggar_profile';
    protected $fillable = [
        'nama_sanggar','tagline','sejarah','visi','misi','tahun_berdiri',
        'alamat','no_hp','email','instagram','facebook','youtube',
        'foto_profil','foto_sejarah',
        'jumlah_anggota','jumlah_penghargaan','jumlah_event',
    ];
    protected $casts = ['misi' => 'array'];

    /** Ambil satu-satunya row profil, buat jika belum ada */
    public static function getInstance(): static {
        return static::firstOrCreate([], [
            'nama_sanggar'       => 'Sanggar Mulya Bhakti',
            'tagline'            => 'Melestarikan Budaya Melalui Seni',
            'sejarah'            => 'Diisi sejarah sanggar...',
            'visi'               => 'Menjadi sanggar seni tari tradisional terdepan di Indonesia.',
            'misi'               => ['Melestarikan seni tari tradisional Indramayu.'],
            'tahun_berdiri'      => '2005',
            'jumlah_anggota'     => 200,
            'jumlah_penghargaan' => 49,
            'jumlah_event'       => 100,
        ]);
    }
}