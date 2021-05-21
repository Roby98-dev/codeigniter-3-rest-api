<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Mahasiswa_model');
    }

    public function index_get()
    {

        $id = $this->get('id');

        if ($id === null) {
            // Users from a data store in database
            $users = $this->Mahasiswa_model->getMahasiswa();
        } else {
            $users = $this->Mahasiswa_model->getMahasiswa($id);
        }

        // Check if the users data store contains users
        if ($users) {
            $this->response($users, 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No users were found'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id) {
            if ($this->Mahasiswa_model->deleteMahasiswa($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'User was deleted'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'No users were found'
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Provide id'
            ], 400);
        }
    }

    public function index_post() {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->Mahasiswa_model->createMahasiswa($data) > 0) {
           $this->response([
                    'status' => true,
                    'message' => 'Success added new Mahasiswa',
                ], 201);
        } else {
            $this->response([
                    'status' => false,
                    'message' => 'Faild added new Mahasiswa',
                ], 400);
        }
    }

    public function index_put() {
        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->Mahasiswa_model->updateMahasiswa($data, $id) > 0) {
           $this->response([
                    'status' => true,
                    'message' => 'Success updated new Mahasiswa',
                ], 200);
        } else {
            $this->response([
                    'status' => false,
                    'message' => 'Faild updated new Mahasiswa',
                ], 400);
        }
    }
}
