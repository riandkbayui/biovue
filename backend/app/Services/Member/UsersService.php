<?php

namespace App\Services\Member;

use App\Models\UsersModel;
use App\Libraries\Auth;

class UsersService
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    /**
     * Update profil user
     */
    public function updateProfile(array $data)
    {
        $user = $this->usersModel->find(Auth::id());
        if (!$user) return ['success' => false, 'message' => 'User tidak ditemukan.'];

        // Cek username unik jika diubah
        if (isset($data['username']) && $data['username'] !== $user->username) {
            if ($this->usersModel->where('username', $data['username'])->first()) {
                return ['success' => false, 'message' => 'Username sudah digunakan.'];
            }
            $user->username = $data['username'];
        }

        if (isset($data['name'])) $user->name = $data['name'];
        if (isset($data['photo'])) $user->photo = $data['photo'];

        if (!$this->usersModel->save($user)) {
            return [
                'success' => false,
                'message' => 'Gagal memperbarui profil.',
                'errors' => $this->usersModel->errors()
            ];
        }

        return [
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'photo' => $user->photo,
                'role' => $user->role
            ]
        ];
    }

    /**
     * Ganti Password
     */
    public function changePassword(string $oldPassword, string $newPassword)
    {
        $user = $this->usersModel->find(Auth::id());
        if (!$user) return ['success' => false, 'message' => 'User tidak ditemukan.'];

        if (!password_verify($oldPassword, $user->password)) {
            return ['success' => false, 'message' => 'Kata sandi lama salah.'];
        }

        $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->usersModel->save($user);

        return ['success' => true, 'message' => 'Kata sandi berhasil diubah.'];
    }
}
