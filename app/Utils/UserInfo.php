<?php

namespace App\Utils;

class UserInfo
{
    private string $username;
    private string $password;
    private string $trabajador_id;
    private int $rol_id;

    public function __construct(string $username, string $password, string $trabajador_id, int $rol_id)
    {
        $this->username = $username;
        $this->password = $password;
        $this->trabajador_id = $trabajador_id;
        $this->rol_id = $rol_id;
    }

    public function getUsername()
    {
        if ($this->username ===  '') {
            return $this->trabajador_id;
        }

        return $this->username;
    }

    public function getPassword()
    {
        if ($this->password === '') {
            return md5(sha1($this->trabajador_id));
        }

        return md5(sha1($this->password));
    }

    public function getTrabajadorId()
    {
        return $this->trabajador_id;
    }

    public function getRolId()
    {
        return $this->rol_id;
    }
}
