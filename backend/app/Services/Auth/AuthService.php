<?php

namespace App\Services\Auth;

use App\Models\UsersModel;
use App\Models\TokensModel;
use App\Models\AttemptsModel;
use CodeIgniter\I18n\Time;

class AuthService
{
    protected $usersModel;
    protected $tokensModel;
    protected $attemptsModel;

    public function __construct()
    {
        $this->usersModel    = new UsersModel();
        $this->tokensModel   = new TokensModel();
        $this->attemptsModel = new AttemptsModel();
    }

    /**
     * Mendaftarkan pengguna baru.
     */
    public function register(array $data)
    {
        // Validasi username/email duplikat
        $existing = $this->usersModel
            ->where('email', $data['email'])
            ->orWhere('username', $data['username'])
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Email atau Username sudah terdaftar.'
            ];
        }

        // Simpan user baru
        $userData = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => 'member', // Default role
            'status'   => 'active',
        ];

        if (!$this->usersModel->insert($userData)) {
            return [
                'success' => false,
                'message' => 'Gagal mendaftarkan pengguna.',
                'errors'  => $this->usersModel->errors()
            ];
        }

        return [
            'success' => true,
            'message' => 'Pendaftaran berhasil. Silakan login.',
        ];
    }

    /**
     * Proses Login
     */
    public function login(string $credential, string $password, string $ipAddress, string $userAgent)
    {
        // Cari user berdasarkan email atau username
        $user = $this->usersModel
            ->where('email', $credential)
            ->orWhere('username', $credential)
            ->first();

        // Catat attempt (percobaan login)
        $attemptData = [
            'ip_address' => $ipAddress,
            'user_id'    => $user ? $user->id : null,
            'user_agent' => $userAgent,
            'success'    => false, // Default gagal
        ];

        if (!$user) {
            $this->attemptsModel->insert($attemptData);
            return [
                'success' => false,
                'message' => 'Kredensial tidak valid.'
            ];
        }

        if ($user->status !== 'active') {
            $this->attemptsModel->insert($attemptData);
            return [
                'success' => false,
                'message' => 'Akun dinonaktifkan.'
            ];
        }

        // Verifikasi Password
        if (!password_verify($password, $user->password)) {
            $this->attemptsModel->insert($attemptData);
            return [
                'success' => false,
                'message' => 'Kredensial tidak valid.'
            ];
        }

        // Login Berhasil
        $attemptData['success'] = true;
        $this->attemptsModel->insert($attemptData);

        // Simpan ke Session untuk mempermudah integrasi SPA build
        $session = session();
        $session->set('user_id', $user->id);
        $session->set('is_logged_in', true);

        // Generate Token
        $tokenStr = bin2hex(random_bytes(32));
        $expiredAt = Time::now()->addDays(7); // Token berlaku 7 hari

        $this->tokensModel->insert([
            'user_id'    => $user->id,
            'type'       => 'auth_bearer',
            'token'      => $tokenStr,
            'value'      => null,
            'expired_at' => $expiredAt->toDateTimeString(),
        ]);

        return [
            'success' => true,
            'data'    => [
                'token' => $tokenStr,
                'user'  => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'role'     => $user->role,
                    'photo'    => $user->photo,
                ]
            ]
        ];
    }

    /**
     * Logout (Hapus Token)
     */
    public function logout(string $token = null)
    {
        if ($token) {
            $tokenRecord = $this->tokensModel->where('token', $token)->first();
            if ($tokenRecord) {
                $this->tokensModel->delete($tokenRecord->id);
            }
        }
        
        // Hancurkan Session
        session()->destroy();
        
        return ['success' => true];
    }

    /**
     * Ambil User berdasarkan ID
     */
    public function getUserById(int $id)
    {
        return $this->usersModel->find($id);
    }

    /**
     * Ambil User dari Token
     */
    public function getUserByToken(string $token)
    {
        $tokenRecord = $this->tokensModel
            ->where('token', $token)
            ->where('type', 'auth_bearer')
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$tokenRecord) {
            return null;
        }

        return $this->usersModel->find($tokenRecord->user_id);
    }
}
