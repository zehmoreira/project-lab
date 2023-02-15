<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AbstractRepository 
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findById(mixed $id): Model
    {
        $model = $this->model->where('id', $id)
            ->get()
            ->first();

        if (!$model) 
        {
            throw new ModelNotFoundException(
                'Objeto não encontrado'
            );
        }

        return $model;
    }

}