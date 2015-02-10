<?php

namespace ChrKo\SEPA;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class DirectDebit
 * @package ChrKo\SEPA
 */
class DirectDebit
{
    /**
     * @var Creditor
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
     * @param Creditor $creditor
     */
    public function __construct(Creditor $creditor)
    {
        $this->setDueDate(new \DateTime());
        $this->setCreditor($creditor);

        $this->mandates = new ArrayCollection();
    }

    /**
     * @param Creditor $creditor
     *
     * @return $this
     */
    public function setCreditor(Creditor $creditor)
    {
        $this->creditor = $creditor;

        return $this;
    }

    /**
     * @return Creditor
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @param string|\DateTime $dueDate
     *
     * @return $this
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
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param float $amount
     *
     * @return $this
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function addMandate(Mandate $mandate)
    {
        $this->mandates[] = $mandate;

        return $this;
    }

    /**
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function removeMandate(Mandate $mandate)
    {
        $this->mandates->removeElement($mandate);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMandates()
    {
        return $this->mandates;
    }
}