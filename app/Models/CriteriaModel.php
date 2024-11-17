<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'criteria_models';

    protected $fillable =[
        'code',
        'type',
        'weight',
        'description'
    ];

    public function alternatifSkor()
    {
        return $this->hasMany(AlternatifSkor::class, 'criteria_id');
    }
}
