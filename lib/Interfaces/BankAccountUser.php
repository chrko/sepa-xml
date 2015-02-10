<?php

namespace ChrKo\SEPA\Interfaces;

use ChrKo\SEPA\BankAccount;

/**
 * Interface BankAccountUser
 * @package ChrKo\SEPA\Interfaces
 */
interface BankAccountUser
{
    /**
     * @param BankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount(BankAccount $bankAccount);

    /**
     * @return BankAccount
     */
    public function getBankAccount();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIban();

    /**
     * @return string
     */
    public function getBic();
}