<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dietas extends Model
{
    protected $table = 'dietas';

    protected $primaryKey = 'idDieta';

    public $timestamps = false;

    protected $fillable = [
        'idPaciente',
        'idAntropometria',
        'inicioDieta',
        'horarioRefeicao',
        'tipoDieta',
        'pesoAtual'
    ];
}
