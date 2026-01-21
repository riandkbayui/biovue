<?php

namespace App\Services\Admin;

use App\Models\UsersModel;
use App\Libraries\Auth;

class AdminUsersService
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function getAllUsers()
    {
        return $this->usersModel->orderBy('created_at', 'DESC')->findAll();
    }

    public function getUser(int $id)
    {
        return $this->usersModel->find($id);
    }

    public function createUser(array $data)
    {
        // Validasi duplikasi email/username
        if ($this->usersModel->where('email', $data['email'])->first()) {
            return ['success' => false, 'message' => 'Email sudah terdaftar.'];
        }
        if ($this->usersModel->where('username', $data['username'])->first()) {
            return ['success' => false, 'message' => 'Username sudah terdaftar.'];
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_by'] = Auth::id();
        
        if (!$this->usersModel->save($data)) {
            return ['success' => false, 'message' => 'Gagal membuat pengguna.', 'errors' => $this->usersModel->errors()];
        }

        return ['success' => true, 'message' => 'Pengguna berhasil dibuat.'];
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->usersModel->find($id);
        if (!$user) return ['success' => false, 'message' => 'User tidak ditemukan.'];

        // Cek unik jika diubah
        if (isset($data['email']) && $data['email'] !== $user->email) {
             if ($this->usersModel->where('email', $data['email'])->first()) {
                return ['success' => false, 'message' => 'Email sudah terdaftar.'];
            }
        }
        if (isset($data['username']) && $data['username'] !== $user->username) {
             if ($this->usersModel->where('username', $data['username'])->first()) {
                return ['success' => false, 'message' => 'Username sudah terdaftar.'];
            }
        }

        // Update password jika ada
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        $data['updated_by'] = Auth::id();

        if (!$this->usersModel->update($id, $data)) {
            return ['success' => false, 'message' => 'Gagal memperbarui pengguna.', 'errors' => $this->usersModel->errors()];
        }

        return ['success' => true, 'message' => 'Pengguna berhasil diperbarui.'];
    }

    public function deleteUser(int $id)
    {
        if (!$this->usersModel->delete($id)) {
            return ['success' => false, 'message' => 'Gagal menghapus pengguna.'];
        }
        return ['success' => true, 'message' => 'Pengguna berhasil dihapus.'];
    }
}
