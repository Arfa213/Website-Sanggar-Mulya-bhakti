<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model {
    protected $table = 'jadwal_latihan';
    protected $fillable = ['hari','jam_mulai','jam_selesai','kelas','tempat','urutan','aktif'];
    protected $casts = ['aktif' => 'boolean'];
    public function scopeAktif($q) { return $q->where('aktif', true)->orderBy('urutan'); }
    public function getJamAttribute(): string {
        return $this->jam_mulai . ' – ' . $this->jam_selesai;
    }
}