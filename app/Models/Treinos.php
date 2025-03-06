<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treinos extends Model
{
    protected $table = 'treinos';

    protected $primaryKey = 'idTreino';

    protected $fillable = [
        'idPaciente',
        'idAntropometria',
        'inicioTreino',
        'tipoTreino',
        'grupoMuscular',
        'nomeExercicio',
        'seriesTreino',
        'repeticoesTreino',
        'cargaInicial',
        'cargaAtual',
        'tempoDescanso',
        'diaSemana',
        'linksExecucao',
        'atualizacaoTreino'
    ];
}
