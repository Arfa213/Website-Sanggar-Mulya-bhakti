<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model {
    protected $table = 'galeri';
    protected $fillable = ['judul','file','tipe','seksi','urutan','aktif'];
    protected $casts = ['aktif' => 'boolean'];
    public function scopeAktif($q)        { return $q->where('aktif', true)->orderBy('urutan'); }
    public function scopeSeksi($q, $seksi){ return $q->where('seksi', $seksi); }
    public function getUrlAttribute(): string {
        return asset('storage/' . $this->file);
    }
}