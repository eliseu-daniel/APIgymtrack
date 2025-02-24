<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{

    use HasApiTokens;

    protected $table = 'usuarios';

    protected $primaryKey = 'idUsuario';

    public $timestamps = false; // usado quando nao tem no banco as tabelas de 'criado'e 'modificado'

    protected $fillable = [
        'nomeUsuario',
        'telefoneUsuario',
        'emailUsuario',
        'senhaUsuario',
        'tipoUsuario',
        'tipoPlanoUsuario',
        'pagamentoUsuario',
    ];

    protected $hidden = [
        'senhaUsuario'
    ];

    public function setSenhaUsuarioAttribute($value)
    {
        $this->attributes['senhaUsuario'] = bcrypt($value);
    }
}


/*
http://127.0.0.1:8000/api/v1/usuarios

{
    "nomeUsuario": "novo Usuario",
    "telefoneUsuario": "129384610273",
    "emailUsuario": "novousuario@gmail.com",
    "senhaUsuario": "1234123",
    "tipoUsuario": "admin",
    "tipoPlanoUsuario": "pago",
    "pagamentoUsuario": "S"
}
*/ 