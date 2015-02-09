<?php

namespace ChrKo\SEPA\Drivers\libsepa;

use ChrKo\SEPA\Abstracts\Creditor as AbstractCreditor;

/**
 * Class Creditor
 * @package ChrKo\SEPA\Drivers\libsepa
 */
class Creditor
    extends AbstractCreditor
{
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
}