<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifSkor extends Model
{
    use HasFactory;

    protected $table = 'alternatif_skors';

    protected $fillable =[
        'alternatif_id',
        'criteria_id',
        'score'
    ];

    public function alternatif()
    {
        return $this->belongsTo(AlternatifModel::class, 'alternatif_id', 'id');
    }

    public function criteria()
    {
        return $this->belongsTo(CriteriaModel::class, 'criteria_id');
    }
}
