<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aparelho extends Model
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
    ];

    /**
     * Get the filial that the aparelho belongs to.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
