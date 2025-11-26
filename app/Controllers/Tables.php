<?php

namespace App\Controllers;

use App\Models\TableModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Tables extends ResourceController
{
    protected $modelName = TableModel::class;
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null): ResponseInterface
    {
        $table = $this->model->find($id);

        if ($table === null) {
            return $this->failNotFound('Mesa no encontrada');
        }

        return $this->respond($table);
    }

    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'name'     => 'required|min_length[2]',
            'capacity' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated($this->model->find($id), 'Mesa creada exitosamente');
    }

    public function update($id = null): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'name'     => 'permit_empty|min_length[2]',
            'capacity' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $table = $this->model->find($id);

        if ($table === null) {
            return $this->failNotFound('Mesa no encontrada');
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id), 200, 'Mesa actualizada exitosamente');
    }

    public function delete($id = null): ResponseInterface
    {
        $table = $this->model->find($id);

        if ($table === null) {
            return $this->failNotFound('Mesa no encontrada');
        }

        $this->model->delete($id);

        return $this->respondDeleted($table, 'Mesa eliminada exitosamente');
    }
}


