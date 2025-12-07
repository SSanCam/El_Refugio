<?php

return [

    'required' => 'El campo :attribute es obligatorio.',
    'email'    => 'El campo :attribute debe ser un correo válido.',
    'max'      => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'min'      => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'unique'    => 'El valor del campo :attribute ya está en uso.',

    'attributes' => [
        'email'    => 'correo electrónico',
        'name'     => 'nombre',
        'password' => 'contraseña',
    ],

];
