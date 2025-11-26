<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Reservations extends ResourceController
{
    protected $modelName = ReservationModel::class;
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null): ResponseInterface
    {
        $reservation = $this->model->find($id);

        if ($reservation === null) {
            return $this->failNotFound('Reserva no encontrada');
        }

        return $this->respond($reservation);
    }

    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'customer_name'        => 'required|min_length[3]',
            'customer_phone'       => 'required',
            'table_id'             => 'required|integer',
            'reservation_datetime' => 'required',
            'people_count'         => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated($this->model->find($id), 'Reserva creada exitosamente');
    }

    public function update($id = null): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'customer_name'        => 'permit_empty|min_length[3]',
            'customer_phone'       => 'permit_empty',
            'table_id'             => 'permit_empty|integer',
            'reservation_datetime' => 'permit_empty',
            'people_count'         => 'permit_empty|integer',
            'status'               => 'permit_empty|in_list[pending,confirmed,cancelled]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $reservation = $this->model->find($id);

        if ($reservation === null) {
            return $this->failNotFound('Reserva no encontrada');
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id), 200, 'Reserva actualizada exitosamente');
    }

    public function delete($id = null): ResponseInterface
    {
        $reservation = $this->model->find($id);

        if ($reservation === null) {
            return $this->failNotFound('Reserva no encontrada');
        }

        $this->model->delete($id);

        return $this->respondDeleted($reservation, 'Reserva eliminada exitosamente');
    }
}


