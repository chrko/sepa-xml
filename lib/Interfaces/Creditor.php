<?php

namespace ChrKo\SEPA\Interfaces;

/**
 * Interface Creditor
 * @package ChrKo\SEPA\Interfaces
 */
interface Creditor
    extends BankAccountUser
{
    /**
     * @param BankAccount $bankAccount
     * @param             $creditorId
     */
    public function __construct(BankAccount $bankAccount, $creditorId);

    /**
     * @param BankAccount $bankAccount
     * @param string      $creditorId
     *
     * @return Creditor
     */
    public static function create(BankAccount $bankAccount, $creditorId);

    /**
     * @param string $name
     * @param string $iban
     * @param string $bic
     * @param string $creditorId
     *
     * @return mixed
     */
    public static function createFromScratch($name, $iban, $bic, $creditorId);

    /**
     * @param string $creditorIdentifier
     *
     * @return $this
     */
    public function setCreditorIdentifier($creditorIdentifier);

    /**
     * @return string
     */
    public function getCreditorIdentifier();
}