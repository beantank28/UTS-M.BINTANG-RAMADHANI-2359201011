<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = [

    ];

    public function galleries(){
        return $this->hasMany( PortoGalleries::class, 'portofolio_id', 'id' );
    }
}
