<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \LaravelDoctrine\ORM\Auth\Authenticatable as AuthenticatableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Webpatser\Uuid\Uuid;
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

    /**
     * @ORM\OneToMany(targetEntity="Wallet", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection|Wallet[]
     */
    protected $wallets;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email  = $email;
        $this->password = $password;

        $this->wallets = new ArrayCollection;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function addWallet(Wallet $wallet)
    {
        if(!$this->wallets->contains($wallet)) {
            $wallet->setUser($this);
            $wallet->addCapital(new Capital(Uuid::generate(),'RUB'));
            $wallet->addCapital(new Capital(Uuid::generate(),'USD'));
            $wallet->addCapital(new Capital(Uuid::generate(),'EUR'));
            $wallet->addCapital(new Capital(Uuid::generate(),'KGS'));
            $this->wallets->add($wallet);
        }
    }

    public function getWallets()
    {
        return $this->wallets;
    }
}