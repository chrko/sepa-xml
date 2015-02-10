<?php

namespace ChrKo\SEPA;

use ChrKo\SEPA\Interfaces\BankAccountUser as IBankAccountUser;
use ChrKo\SEPA\Traits\BankAccountUser;

/**
 * Class Creditor
 * @package ChrKo\SEPA
 */
class Creditor
    implements IBankAccountUser
{
    use BankAccountUser;

    /**
     * @var string
     */
    protected $creditorIdentifier = null;

    /**
     * @param BankAccount $bankAccount
     * @param             $creditorId
     */
    public function __construct(BankAccount $bankAccount, $creditorId)
    {
        $this->bankAccount = $bankAccount;
        $this->setCreditorIdentifier($creditorId);
    }

    /**
     * @param BankAccount $bankAccount
     * @param string      $creditorId
     *
     * @return Creditor
     */
    public static function create(BankAccount $bankAccount, $creditorId)
    {
        return new static($bankAccount, $creditorId);
    }

    /**
     * @param string $name
     * @param string $iban
     * @param string $bic
     * @param string $creditorId
     *
     * @return Creditor
     */
    public static function createFromScratch($name, $iban, $bic, $creditorId)
    {
        return new static(new BankAccount($name, $iban, $bic), $creditorId);
    }

    /**
     * @param string $creditorIdentifier
     *
     * @return $this
     */
    public function setCreditorIdentifier($creditorIdentifier)
    {
        $this->creditorIdentifier = $creditorIdentifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditorIdentifier()
    {
        return $this->creditorIdentifier;
    }
}
