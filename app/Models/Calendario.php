<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $table = 'calendario';

    protected $primaryKey = 'idCalendario';

    public $timestamps = false;

    protected $fillable = [
        'idPaciente',
        'prazoPlanoCliente',
        'tipoPagamentoCliente',
    ];
}
