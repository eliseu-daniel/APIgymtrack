<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    protected $table = 'Pacientes';

    protected $primaryKey = 'idPaciente';

    public $timestamps = false; // usado quando nao tem no banco as tabelas de 'criado'e 'modificado'

    protected $fillable = [
        'idUsuario',
        'nomePaciente',
        'emailPaciente',
        'telefonePaciente',
        'nascimentoPaciente',
        'planoAcompanhamento',
        'inicioAcompanhamento',
        'fimAcompanhamento',
        'sexoPaciente',
        'pagamento',
        'alergias'
    ];

    
}
