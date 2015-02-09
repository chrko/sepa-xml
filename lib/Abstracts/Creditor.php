<?php

namespace ChrKo\SEPA\Abstracts;

use ChrKo\SEPA\Interfaces\BankAccount as IBankAccount;
use ChrKo\SEPA\Interfaces\Creditor as ICreditor;

use ChrKo\SEPA\Traits\BankAccountUser;

/**
 * Class Creditor
 * @package ChrKo\SEPA\Abstracts
 */
abstract class Creditor
    implements ICreditor
{
    use BankAccountUser;

    /**
     * @var string
     */
    protected $creditorIdentifier = null;

    /**
     * @inheritdoc
     */
    public function __construct(IBankAccount $bankAccount, $creditorId)
    {
        $this->bankAccount = $bankAccount;
        $this->setCreditorIdentifier($creditorId);
    }

    /**
     * @inheritdoc
     */
    public static function create(IBankAccount $bankAccount, $creditorId)
    {
        return new static($bankAccount, $creditorId);
    }

    /**
     * @inheritdoc
     */
    public function setCreditorIdentifier($creditorIdentifier)
    {
        $this->creditorIdentifier = $creditorIdentifier;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreditorIdentifier()
    {
        return $this->creditorIdentifier;
    }
}