<?php

class AuthService {

    public function login($username, $password) {

        // dummy login dulu
        if ($username !== 'admin' || $password !== 'admin') {
            throw new Exception('Username atau password salah');
        }

        session_regenerate_id(true);
        $_SESSION['auth'] = true;
        $_SESSION['role'] = 'admin';
    }
}
