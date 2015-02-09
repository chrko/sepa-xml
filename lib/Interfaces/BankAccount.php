<?php

namespace ChrKo\SEPA\Interfaces;

/**
 * Interface BankAccount
 * @package ChrKo\SEPA\Interfaces
 */
interface BankAccount
{
    /**
     * @param string      $name Account owner
     * @param string|null $iban IBAN
     * @param string|null $bic  BIC
     */
    public function __construct($name, $iban = null, $bic = null);

    /**
     * @param string      $name Account owner
     * @param string|null $iban IBAN
     * @param string|null $bic  BIC
     *
     * @return BankAccount
     */
    public static function create($name, $iban = null, $bic = null);

    /**
     * Sets the account owner name.
     *
     * @param string $name
     *
     * @return BankAccount
     */
    public function setName($name);

    /**
     * Gets the account owner name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the BIC on the account
     *
     * @param string|null $bic BIC
     *
     * @return BankAccount
     */
    public function setBic($bic = null);

    /**
     * @return string|null
     */
    public function getBic();

    /**
     * Sets the IBAN on the account.
     *
     * @param string|null $iban IBAN
     *
     * @return BankAccount
     */
    public function setIban($iban = null);

    /**
     * @return string|null
     */
    public function getIban();

}