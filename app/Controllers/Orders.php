<?php

namespace App\Controllers;

use App\Models\OrderModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Orders extends ResourceController
{
    protected $modelName = OrderModel::class;
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null): ResponseInterface
    {
        $order = $this->model->find($id);

        if ($order === null) {
            return $this->failNotFound('Pedido no encontrado');
        }

        return $this->respond($order);
    }

    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'items'        => 'required',
            'total_amount' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Si items viene como array, lo guardamos como JSON
        if (isset($data['items']) && is_array($data['items'])) {
            $data['items'] = json_encode($data['items']);
        }

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated($this->model->find($id), 'Pedido creado exitosamente');
    }

    public function update($id = null): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'items'        => 'permit_empty',
            'total_amount' => 'permit_empty|decimal',
            'status'       => 'permit_empty|in_list[pending,in_progress,served,paid,cancelled]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $order = $this->model->find($id);

        if ($order === null) {
            return $this->failNotFound('Pedido no encontrado');
        }

        if (isset($data['items']) && is_array($data['items'])) {
            $data['items'] = json_encode($data['items']);
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id), 200, 'Pedido actualizado exitosamente');
    }

    public function delete($id = null): ResponseInterface
    {
        $order = $this->model->find($id);

        if ($order === null) {
            return $this->failNotFound('Pedido no encontrado');
        }

        $this->model->delete($id);

        return $this->respondDeleted($order, 'Pedido eliminado exitosamente');
    }
}


