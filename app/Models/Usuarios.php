<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';

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

    public static function getAll(){
        $users = Usuarios::all();

        return $users;
    }

    public static function create($data)
    {
        // $data['senhaUsuario'] = bcrypt($data['senhaUsuario']);

        $users = Usuarios::create($data);

        return response()->json($users);
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