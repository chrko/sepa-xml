<?php

namespace ChrKo\SEPA\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface DirectDebit
 * @package ChrKo\SEPA\Interfaces
 */
interface DirectDebit
{
    /**
     * @param Creditor $creditor
     */
    public function __construct(Creditor $creditor);

    /**
     * @param Creditor $creditor
     *
     * @return DirectDebit
     */
    public function setCreditor(Creditor $creditor);

    /**
     * @return Creditor
     */
    public function getCreditor();

    /**
     * @param string|\DateTime $dueDate
     *
     * @return DirectDebit
     */
    public function setDueDate($dueDate);

    /**
     * @return \DateTime
     */
    public function getDueDate();

    /**
     * @param float $amount
     *
     * @return DirectDebit
     */
    public function setAmount($amount);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param string $reference
     *
     * @return DirectDebit
     */
    public function setReference($reference);

    /**
     * @return string
     */
    public function getReference();

    /**
     * @param Mandate $mandate
     *
     * @return DirectDebit
     */
    public function addMandate(Mandate $mandate);

    /**
     * @param Mandate $mandate
     *
     * @return DirectDebit
     */
    public function removeMandate(Mandate $mandate);

    /**
     * @return Collection
     */
    public function getMandates();
}