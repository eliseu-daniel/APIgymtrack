<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackDieta extends Model
{
    protected $table = 'feedbackdieta';

    protected $primaryKey = 'idFeedback';

    protected $fillable = [
        'idDieta',
        'idPaciente',
        'comentario',
        'dataFeedbackDieta'
    ];
}
