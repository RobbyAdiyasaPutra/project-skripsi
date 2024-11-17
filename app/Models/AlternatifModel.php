<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifModel extends Model
{
    use HasFactory;

    protected $table = 'alternatif_models';

    protected $fillable =[
        'name'
    ];

    public function alternatifSkor()
    {
        return $this->hasMany(AlternatifSkor::class, 'alternatif_id');
    }
}
