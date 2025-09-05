<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filial extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'filiais';
    protected $fillable = [
        'academia_id',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
    ];

    /**
     * Get the academia that the filial belongs to.
     */
    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }

    /**
     * Get the alunos for the filial.
     */
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    /**
     * Get the aparelhos for the filial.
     */
    public function aparelhos()
    {
        return $this->hasMany(Aparelho::class);
    }
}
