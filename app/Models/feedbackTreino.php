<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class feedbackTreino extends Model
{
    protected $table = 'feedbacks';

    protected $primaryKey = 'idFeedback';

    protected $fillable = [
        'idTreino',
        'idPaciente',
        'comentario',
        'dataFeedback'
    ];
}
