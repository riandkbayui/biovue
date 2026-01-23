<?php

namespace App\Controllers\Api\Member;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Member\PagesService;
use Exception;

class Pages extends ResourceController
{
    protected $pagesService;
    protected $format = 'json';

    public function __construct()
    {
        $this->pagesService = new PagesService();
    }

    public function getIndex()
    {
        try {
            $perPage = $this->request->getVar('perPage') ?? 9;
            $result = $this->pagesService->getPaginated((int)$perPage);
            return $this->respond($result);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getShow($id = null)
    {
        try {
            $data = $this->pagesService->getOne((int)$id);
            if (!$data) return $this->failNotFound('Halaman tidak ditemukan');
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postCreate()
    {
        try {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[255]',
                'description' => 'permit_empty|max_length[1000]'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $input = [
                'title'       => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
            ];

            $result = $this->pagesService->create($input);
            return $result['success'] ? $this->respondCreated($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function putUpdate($id = null)
    {
        try {
            $rules = [
                'title'       => 'required|min_length[3]|max_length[255]',
                'description' => 'permit_empty|max_length[1000]'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $input = (array) $this->request->getVar();
            $result = $this->pagesService->update((int)$id, $input);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteDelete($id = null)
    {
        try {
            $result = $this->pagesService->delete((int)$id);
            return $result['success'] ? $this->respondDeleted($result) : $this->failNotFound($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postSaveAll($id = null)
    {
        try {
            $input = (array) $this->request->getVar();
            $result = $this->pagesService->saveAll((int)$id, $input);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}