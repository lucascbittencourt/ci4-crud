<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    use ResponseTrait;

    private readonly User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function paginate(): ResponseInterface
    {
        $length = (int)$this->request->getVar('length') ?: 10;
        $start = (int)$this->request->getVar('start');
        $page = $start / ($length + 1);

        $search = $this->request->getVar('search[value]');
        $order = $this->request->getVar('order[0]');

        if ($search) {
            $this->userModel->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('username', $search)
                ->orLike('email', $search);
        }
        $column = $order['column'] ?? 'id';
        $direction = $order['dir'] ?? 'ASC';

        $paginate = $this->userModel->orderBy($column, $direction)
            ->paginate(
                perPage: $length,
                page: $page
            );

        return $this->respond([
            'data' => $paginate,
            'recordsTotal' => $this->userModel->pager->getTotal(),
            'recordsFiltered' => $this->userModel->pager->getTotal(),
        ]);
    }

    public function store(): ResponseInterface
    {
        if (!$this->validate('userStoreRules')) {
            return $this->respond($this->validator->getErrors(), 422);
        }

        $data = $this->request->getVar([
            'first_name',
            'last_name',
            'mobile',
            'email',
            'username',
            'password',
            'password_confirm',
        ]);

        $this->userModel->insert($data);

        return $this->respondCreated([
            'id' => $this->userModel->getInsertID(),
        ]);
    }

    public function update(int $id): ResponseInterface
    {
        $data = $this->request->getVar([
            'first_name',
            'last_name',
            'mobile',
            'email',
            'username',
            'password',
            'password_confirm',
        ]);

        $data['id'] = $id;

        if (!$this->validateData($data, 'userUpdateRules')) {
            return $this->respond($this->validator->getErrors(), 422);
        };

        $this->userModel->update($id, $data);

        return $this->respondNoContent();
    }

    public function delete(int $id): ResponseInterface
    {
        $this->userModel->delete($id);

        return $this->respondDeleted();
    }
}
