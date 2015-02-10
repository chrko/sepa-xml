<?php

namespace ChrKo\SEPA;

use ChrKo\SEPA\Exceptions\InvalidStateException;

use ChrKo\SEPA\Interfaces\BankAccountUser as IBankAccountUser;
use ChrKo\SEPA\Traits\BankAccountUser;

/**
 * Class Mandate
 * @package ChrKo\SEPA
 */
class Mandate
    implements IBankAccountUser
{
    use BankAccountUser;

    const FIRST = 1;
    const RECURRING = 2;
    const LAST = 3;

    const UNIQUE = 'OOFF';
    const ONE_OFF = 'OOFF';

    /**
     * @var string
     */
    protected $mandateReference;

    /**
     * @var \DateTime
     */
    protected $mandateDate;

    /**
     * @var Mandate
     */
    protected $oldMandate = null;

    /**
     * @var string|integer
     */
    protected $type = self::RECURRING;

    /**
     * @var string
     */
    protected $state = self::FIRST;

    public function __construct()
    {
        $this->mandateDate = new \DateTime();
    }

    /**
     * @inheritdoc
     */
    public function setMandateReference($mandateReference)
    {
        if (!is_string($mandateReference)) {
            throw new \InvalidArgumentException('Mandate reference must be a string.');
        }
        if (preg_match('#^[0-9A-Za-z\',.:+-/()?]{1,35}$#', $mandateReference) === 0) {
            throw new \InvalidArgumentException('Invalid mandate reference string, ...');
        }

        $this->mandateReference = $mandateReference;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMandateReference()
    {
        return $this->mandateReference;
    }

    /**
     * @inheritdoc
     */
    public function setMandateDate($mandateDate)
    {
        $this->mandateDate = $mandateDate;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMandateDate()
    {
        return $this->mandateDate;
    }

    /**
     * @inheritdoc
     */
    public function setOldMandate(Mandate $oldMandate)
    {
        $this->oldMandate = $oldMandate;
    }

    /**
     * @inheritdoc
     */
    public function getOldMandate()
    {
        return $this->oldMandate;
    }

    /**
     * @inheritdoc
     */
    public function setType($type)
    {
        if (!in_array($type, [static::RECURRING, static::UNIQUE], true)) {
            throw new \InvalidArgumentException('Only Mandate::RECURRING or Mandate::UNIQUE are allowed.');
        }

        if ($type === static::UNIQUE) {
            $this->state = static::ONE_OFF;
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return (string)$this->type;
    }

    /**
     * @inheritdoc
     */
    public function isType($type)
    {
        return $this->type == $type;
    }

    /**
     * @inheritdoc
     */
    public function setState($state)
    {
        if (!in_array($state, [static::FIRST, static::RECURRING, static::LAST, static::ONE_OFF], true)) {
            throw new \InvalidArgumentException('Only Mandate::FIRST, Mandate::RECURRING, Mandate::LAST, Mandate::ONE_OFF');
        }

        switch ($this->type) {
            case static::RECURRING:
                switch ($this->state) {
                    case static::FIRST:
                        if (!in_array($state, [static::FIRST, static::RECURRING, static::LAST])) {
                            break;
                        }
                        break 2;
                    case static::RECURRING:
                        if (!in_array($state, [static::RECURRING, static::LAST])) {
                            break;
                        }
                        break 2;
                    case static::LAST:
                        if ($state !== static::LAST) {
                            break;
                        }
                        break 2;
                    default:
                        throw new InvalidStateException('Here is something terrible wrong');
                }
                throw new InvalidStateException('Setting the state on failed.');
                break;
            case static::UNIQUE:
                if ($state !== static::ONE_OFF) {
                    throw new InvalidStateException('Cannot set any other state on a one time mandate.');
                }
                break;
            default:
                throw new InvalidStateException('Cannot set state, if no type is specified.');
        }

        $this->state = $state;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getState()
    {
        return $this->state;
    }

}
