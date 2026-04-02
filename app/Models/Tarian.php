<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarian extends Model {
    use HasFactory;
    protected $table = 'tarian';
    protected $fillable = [
        'nama','asal','kategori','deskripsi','fungsi',
        'kostum','durasi','foto','video_url','unggulan','urutan','aktif',
    ];
    protected $casts = [
        'unggulan' => 'boolean',
        'aktif'    => 'boolean',
    ];
    public function scopeAktif($q)   { return $q->where('aktif', true)->orderBy('urutan'); }
    public function scopeUnggulan($q){ return $q->where('unggulan', true); }
}