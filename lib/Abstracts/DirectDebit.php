<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 09.02.15
 * Time: 19:30
 */

namespace ChrKo\SEPA\Abstracts;

use ChrKo\SEPA\Interfaces\Creditor as ICreditor;
use ChrKo\SEPA\Interfaces\DirectDebit as IDirectDebit;
use ChrKo\SEPA\Interfaces\Mandate as IMandate;
use Doctrine\Common\Collections\ArrayCollection;

abstract class DirectDebit
    implements IDirectDebit
{
    /**
     * @var ICreditor
     */
    protected $creditor;

    /**
     * @var \DateTime
     */
    protected $dueDate;

    /**
     * @var float
     */
    protected $amount = 0;

    /**
     * @var string
     */
    protected $reference = null;

    /**
     * @var ArrayCollection
     */
    protected $mandates;

    /**
     * @inheritdoc
     */
    public function __construct(ICreditor $creditor)
    {
        $this->setDueDate(new \DateTime());
        $this->setCreditor($creditor);

        $this->mandates = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function setCreditor(ICreditor $creditor)
    {
        $this->creditor = $creditor;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @inheritdoc
     */
    public function setDueDate($dueDate)
    {
        if (is_string($dueDate)) {
            $dueDate = \DateTime::createFromFormat('Y-m-d', $dueDate);
        }
        if (!($dueDate instanceof \DateTime)) {
            throw new \InvalidArgumentException('Parameter $dueDate is not a \DateTime Object neither in format Y-m-d');
        }

        $dueDate->setTime(12, 0, 0);

        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @inheritdoc
     */
    public function setAmount($amount)
    {
        $amount = (float)$amount;
        if (!(is_float($amount) && $amount >= 0)) {
            throw new \InvalidArgumentException('Cannot set $amount ' . $amount);
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @inheritdoc
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @inheritdoc
     */
    public function addMandate(IMandate $mandate)
    {
        $this->mandates[] = $mandate;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeMandate(IMandate $mandate)
    {
        $this->mandates->removeElement($mandate);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMandates()
    {
        return $this->mandates;
    }
}