<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="capitals")
 */

class Capital
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, options={"fixed" = true})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=36, options={"fixed" = true})
     */
    protected $wallet_id;

    /**
     * @ORM\ManyToOne(targetEntity="Wallet", inversedBy="capitals")
     * @var Wallet
     */
    protected $wallet;

    /**
     * @ORM\Column(type="string")
     */
    protected $currency;

    /**
     * @ORM\Column(type="float")
     */
    protected $amount;

    public function __construct($id,$currency)
    {
        $this->id = $id;
        $this->currency = $currency;
        $this->amount = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setWallet(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function getWallet()
    {
        return $this->wallet;
    }

    public function increaseAmount($sum)
    {
        $this->amount += $sum;
        
    }

    public function decreaseAmount($sum)
    {
        // check
        $amount = $this->amount;

        if ($amount - $sum > 0){
            $this->amount -= $sum;
            return true;
        }else{
            return false;
        }
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getAmount()
    {
        return $this->amount;
    }

}