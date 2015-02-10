<?php

namespace ChrKo\SEPA\Traits;

use ChrKo\SEPA\BankAccount;

/**
 * Class BankAccountUser
 * @package ChrKo\SEPA\Traits
 */
trait BankAccountUser
{
    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @param BankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    public function getName()
    {
        return $this->bankAccount->getName();
    }

    public function getIban()
    {
        return $this->bankAccount->getIban();
    }

    public function getBic()
    {
        return $this->bankAccount->getBic();
    }
}