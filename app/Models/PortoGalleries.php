<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortoGalleries extends Model
{
    use HasFactory;

    protected $fillable = [
        'photos', 'portofolio_id'
    ];

    protected $hidden = [

    ];

    public function porto(){
        return $this->belongsTo(Porto::class, 'portofolio_id', 'id');
    }
}
