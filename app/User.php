<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \LaravelDoctrine\ORM\Auth\Authenticatable as AuthenticatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */

class User implements AuthenticatableContract
{
    use AuthenticatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */

    private $name;

    /**
     * @ORM\Column(type="string")
     */

    protected $email;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email  = $email;
        $this->password = $password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }
}