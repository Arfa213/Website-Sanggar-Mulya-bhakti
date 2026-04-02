<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengelola extends Model {
    use HasFactory;
    protected $table = 'pengelola';
    protected $fillable = ['nama','jabatan','ikon','foto','urutan','aktif'];
    protected $casts = ['aktif' => 'boolean'];
    public function scopeAktif($q) { return $q->where('aktif', true)->orderBy('urutan'); }
}