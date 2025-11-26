<?php

namespace App\Controllers;

use App\Models\DishModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Dishes extends ResourceController
{
    protected $modelName = DishModel::class;
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null): ResponseInterface
    {
        $dish = $this->model->find($id);

        if ($dish === null) {
            return $this->failNotFound('Plato no encontrado');
        }

        return $this->respond($dish);
    }

    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'price'       => 'required|decimal',
            'category'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated($this->model->find($id), 'Plato creado exitosamente');
    }

    public function update($id = null): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'name'        => 'permit_empty|min_length[3]',
            'description' => 'permit_empty|min_length[10]',
            'price'       => 'permit_empty|decimal',
            'category'    => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $dish = $this->model->find($id);

        if ($dish === null) {
            return $this->failNotFound('Plato no encontrado');
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id), 200, 'Plato actualizado exitosamente');
    }

    public function delete($id = null): ResponseInterface
    {
        $dish = $this->model->find($id);

        if ($dish === null) {
            return $this->failNotFound('Plato no encontrado');
        }

        $this->model->delete($id);

        return $this->respondDeleted($dish, 'Plato eliminado exitosamente');
    }

    public function search(): ResponseInterface
    {
        $term = $this->request->getGet('term');

        if ($term === null || $term === '') {
            return $this->fail('Debes proveer un término de búsqueda');
        }

        $dishes = $this->model
            ->like('name', $term)
            ->orLike('description', $term)
            ->orLike('category', $term)
            ->findAll();

        return $this->respond($dishes);
    }
}


