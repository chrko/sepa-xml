<?php

namespace ChrKo\SEPA\Abstracts;

use ChrKo\SEPA\Interfaces\BankAccount as IBankAccount;

/**
 * Class BankAccount
 * @package ChrKo\SEPA\Abstracts
 */
abstract class BankAccount
    implements IBankAccount
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $iban;

    /**
     * @var string
     */
    protected $bic;

    /**
     * @inheritdoc
     */
    public function __construct($name, $iban = null, $bic = null)
    {
        $this->name = $name;
        $this->setIban($iban);
        $this->setBic($bic);
    }

    /**
     * @inheritdoc
     */
    public static function create($name, $iban = null, $bic = null)
    {
        return new static($name, $iban, $bic);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setIban($iban = null)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @inheritdoc
     */
    public function setBic($bic = null)
    {
        $this->bic = $bic;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBic()
    {
        return $this->bic;
    }
}