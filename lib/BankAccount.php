<?php

namespace ChrKo\SEPA;

/**
 * Class BankAccount
 * @package ChrKo\SEPA
 */
class BankAccount
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
     * @param string $name Account owner
     * @param string $iban IBAN
     * @param string $bic  BIC
     */
    public function __construct($name, $iban, $bic)
    {
        $this->name = $name;
        $this->setIban($iban);
        $this->setBic($bic);
    }

    /**
     * @param string $name Account owner
     * @param string $iban IBAN
     * @param string $bic  BIC
     *
     * @return BankAccount
     */
    public static function create($name, $iban, $bic)
    {
        return new static($name, $iban, $bic);
    }

    /**
     * Sets the account owner name.
     *
     * @param string $name
     *
     * @return BankAccount
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('no string given');
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the account owner name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the IBAN on the account.
     *
     * @param string $iban IBAN
     *
     * @return BankAccount
     */
    public function setIban($iban)
    {
        if (!is_string($iban)) {
            throw new \InvalidArgumentException('No string neither null given for iban! ' . print_r($iban, true));
        }

        $this->iban = $iban;

        return $this;
    }


    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Sets the BIC on the account
     *
     * @param string $bic BIC
     *
     * @return BankAccount
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function setBic($bic)
    {
        if (!is_string($bic)) {
            throw new \InvalidArgumentException('No string neither null given for bic! ' . print_r($bic, true));
        }

        $len = strlen($bic);
        if (!($len >= 8 && $len <= 11)) {
            throw new \Exception('not the needed length');
        }

        $this->bic = $bic;

        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }
}