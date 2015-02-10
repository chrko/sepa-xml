<?php

namespace ChrKo\SEPA\Interfaces;


use ChrKo\SEPA\DirectDebit;

interface Driver {

    public function generateIban($bankNumber, $accountNumber);

    public function getBicForIban($iban);

    public function isBicValid($bic);

    public function getDirectDebitXml(DirectDebit $directDebit);
}
