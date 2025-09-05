<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTreino extends Model
{
    use HasFactory;

    protected $table = 'fichas_treino';

    protected $fillable = [
        'aluno_id',
        'name',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function exercicios()
    {
        return $this->hasMany(ExercicioFicha::class, 'ficha_treino_id');
    }
}
