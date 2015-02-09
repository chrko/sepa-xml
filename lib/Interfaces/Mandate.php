<?php

namespace ChrKo\SEPA\Interfaces;

/**
 * Interface Mandate
 * @package ChrKo\SEPA\Interfaces
 */
interface Mandate
{
    const FIRST = 1;
    const RECURRING = 2;
    const LAST = 3;

    const UNIQUE = 'OOFF';
    const ONE_OFF = 'OOFF';

    /**
     * @param string $mandateReference
     *
     * @return Mandate
     */
    public function setMandateReference($mandateReference);

    /**
     * @return string
     */
    public function getMandateReference();

    /**
     * @param string|\DateTime $mandateDate
     *
     * @return mixed
     */
    public function setMandateDate($mandateDate);

    /**
     * @return \DateTime
     */
    public function getMandateDate();

    /**
     * @param Mandate $oldMandate
     *
     * @return Mandate
     */
    public function setOldMandate(Mandate $oldMandate);

    /**
     * @return Mandate
     */
    public function getOldMandate();

    /**
     * @param string|integer $type
     *
     * @return Mandate
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string|integer $type
     *
     * @return bool
     */
    public function isType($type);

    /**
     * @param $state
     *
     * @return Mandate
     */
    public function setState($state);

    /**
     * @return string
     */
    public function getState();
}