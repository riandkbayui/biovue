<?php

namespace App\Controllers\Api\Member;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Member\BlocksService;
use Exception;

class Blocks extends ResourceController
{
    protected $blocksService;
    protected $format = 'json';

    public function __construct()
    {
        $this->blocksService = new BlocksService();
    }

    public function getShow($pageId = null)
    {
        try {
            $data = $this->blocksService->getBlocksByPage((int)$pageId);
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postCreate()
    {
        try {
            $rules = [
                'page_id' => 'required|numeric',
                'type'    => 'required',
                'content' => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $result = $this->blocksService->addBlock((int)$this->request->getVar('page_id'), [
                'type'    => $this->request->getVar('type'),
                'content' => $this->request->getVar('content')
            ]);

            return $result['success'] ? $this->respondCreated($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function putUpdate($id = null)
    {
        try {
            $input = (array) $this->request->getVar();
            $result = $this->blocksService->updateBlock((int)$id, $input);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteDelete($id = null)
    {
        try {
            $result = $this->blocksService->deleteBlock((int)$id);
            return $result['success'] ? $this->respondDeleted($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postReorder()
    {
        try {
            $pageId = $this->request->getVar('page_id');
            $ids = $this->request->getVar('ids');

            if (!$pageId || !is_array($ids)) {
                return $this->fail('Data tidak valid.');
            }

            $result = $this->blocksService->reorderBlocks((int)$pageId, $ids);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}