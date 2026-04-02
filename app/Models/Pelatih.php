<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelatih extends Model {
    use HasFactory;
    protected $table = 'pelatih';
    protected $fillable = ['nama','jabatan','spesialisasi','pengalaman','bio','foto','no_hp','urutan','aktif'];
    protected $casts = ['aktif' => 'boolean'];
    public function scopeAktif($q) { return $q->where('aktif', true)->orderBy('urutan'); }
}