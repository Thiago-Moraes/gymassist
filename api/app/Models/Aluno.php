<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filial_id',
        'name',
        'birth_date',
        'objective',
        'experience_level',
        'health_conditions',
        'height',
        'weight',
        'preferred_exercises',
        'avoided_exercises',
        'previous_training',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the filial that the aluno belongs to.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
