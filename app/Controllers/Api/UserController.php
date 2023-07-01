<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User as UserEntity;

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

        $sql = 'users.id = identities.user_id AND identities.type = "email_password"';
        $this->userModel->join('auth_identities as identities', new RawSql($sql), 'left');

        if ($search) {
            $this->userModel->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('username', $search)
                ->orLike('identities.secret', $search);
        }
        $column = $order['column'] ?? 'id';
        $direction = $order['dir'] ?? 'ASC';

        $users = $this->userModel->orderBy("users.$column", $direction)
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'identities.secret as email',
                'users.mobile',
                'users.username',
            ]);
        $paginate = $users->paginate(
            perPage: $length,
            page: $page
        );

        return $this->respond([
            'data' => $paginate,
            'recordsTotal' => $users->countAllResults(),
            'recordsFiltered' => $this->userModel->pager->getTotal(),
        ]);
    }

    public function store(): ResponseInterface
    {
        $rules = setting('Validation.registration');
        $allowedFields = array_keys($rules);

        $payload = $this->request->getVar($allowedFields);

        if (!$this->validateData($payload, $rules)) {
            return $this->respondUnprocessableEntity($this->validator->getErrors());
        }

        $userEntity = new UserEntity();
        $userEntity->fill($payload);

        $this->userModel->save($userEntity);

        $newUser = $this->userModel->findById($this->userModel->getInsertID());
        $this->userModel->addToDefaultGroup($newUser);

        return $this->respondCreated($newUser);
    }

    public function update(int $id): ResponseInterface
    {
        $rules = setting('Validation.userUpdate');
        $allowedFields = array_keys($rules);

        $payload = array_filter($this->request->getVar($allowedFields));
        $payload['id'] = $id;


        if (!$this->validateData($payload, $rules)) {
            return $this->respondUnprocessableEntity($this->validator->getErrors());
        };

        $user = $this->userModel->findById($id);
        $user->fill($payload);

        $this->userModel->save($user);

        return $this->respondNoContent();
    }

    public function delete(int $id): ResponseInterface
    {
        $this->userModel->delete($id, true);

        return $this->respondNoContent();
    }

    private function respondUnprocessableEntity(array $errors): ResponseInterface
    {
        return $this->respond([
            'errors' => $errors,
        ], 422);
    }
}
