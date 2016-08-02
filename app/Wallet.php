<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallets")
 */

class Wallet
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, options={"fixed" = true})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="wallets")
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Capital", mappedBy="wallet", cascade={"persist"})
     * @var ArrayCollection|Capital[]
     */
    protected $capitals;

    public function __construct($id)
    {
        $this->id = $id;

        $this->capitals = new ArrayCollection;
    }

    public function addCapital(Capital $capital)
    {
        if(!$this->capitals->contains($capital)) {
            $capital->setWallet($this);
            $this->capitals->add($capital);
        }
    }

    public function getCapitals()
    {
        return $this->capitals;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}