<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antropometria extends Model
{
    protected $table = 'antropometria';

    protected $primaryKey = 'idAntropometria';

    public $timestamps = false;

    protected $fillable = [
        'idPaciente',
        'pesoInicial',
        'altura',
        'gorduraCorporal',
        'nivelAtvFisica',
        'objetivo',
        'tmb',
        'getAntro',
        'lesoes'
    ];

}
