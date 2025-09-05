<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercicioFicha extends Model
{
    use HasFactory;

    protected $table = 'exercicios_ficha';

    protected $fillable = [
        'ficha_treino_id',
        'exercise',
        'sets',
        'repetitions',
        'observations',
    ];

    public function fichaTreino()
    {
        return $this->belongsTo(FichaTreino::class);
    }
}
