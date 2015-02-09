<?php

namespace ChrKo\SEPA\Traits;

use ChrKo\SEPA\Interfaces\BankAccount as IBankAccount;

/**
 * Class BankAccountUser
 * @package ChrKo\SEPA\Traits
 */
trait BankAccountUser
{
    /**
     * @var IBankAccount
     */
    protected $bankAccount;

    /**
     * @param IBankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount(IBankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * @return IBankAccount
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