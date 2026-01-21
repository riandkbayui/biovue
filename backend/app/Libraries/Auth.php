<?php

namespace App\Libraries;

use App\Entities\User;

class Auth
{
    /**
     * Menyimpan data user yang sedang login secara static
     * @var User|null
     */
    protected static $user = null;

    /**
     * Set user yang sedang login
     */
    public static function set(User $user)
    {
        self::$user = $user;
    }

    /**
     * Ambil data user lengkap
     * @return User|null
     */
    public static function user()
    {
        return self::$user;
    }

    /**
     * Ambil hanya ID user
     * @return int|null
     */
    public static function id()
    {
        return self::$user ? self::$user->id : null;
    }

    /**
     * Cek apakah user adalah admin
     * @return bool
     */
    public static function isAdmin()
    {
        return self::$user && self::$user->role === 'admin';
    }
}
