<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dietas extends Model
{
    protected $table = 'dietas';

    protected $primaryKey = 'idDieta';

    protected $fillable = [
        'idPaciente',
        'refeicao',
        'descricaoRefeicao',
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'idAntropometria',
        'inicioDieta',
        'horarioRefeicao',
        'tipoDieta',
        'pesoMeta',
        'atualizacaoDieta'
    ];
}
