<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DetailPenjualanModel;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';

    protected $fillable = ['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal','image', 'created_at', 'updated_at'];
    protected $casts = [
        'penjualan_tanggal' => 'datetime', // or 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    protected function image(): Attribute 
    { 
        return Attribute::make( 
            get: fn ($image) => url('/storage/posts/' . $image), 
        ); 
    } 
    
}

