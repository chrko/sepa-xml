<?php

namespace ChrKo\SEPA\Drivers\libsepa;

use ChrKo\SEPA\Abstracts\BankAccount as AbstractBankAccount;
use ChrKo\SEPA\Exceptions\InvalidIbanException;
use ChrKo\SEPA\Exceptions\InvalidBicException;


/**
 * Class BankAccount
 * @package ChrKo\SEPA
 */
class BankAccount
    extends AbstractBankAccount
{
    /**
     * @var int
     */
    protected $bankFlags = 0;

    const TRANSFER_CASH = SEPA_SCL_SCT;
    const DIRECT_DEBIT = SEPA_SCL_SDD;
    const DIRECT_DEBIT_FAST = SEPA_SCL_COR1;
    const DEBIT_B2B = SEPA_SCL_B2B;

    /**
     * Sets the IBAN on the account, and maybe also calculate the bic
     *
     * @param string|null $iban         IBAN
     * @param boolean     $calculateBic Should the bic be calculated?
     *
     * @return $this
     * @throws \InvalidArgumentException
     * @throws InvalidIbanException
     */
    public function setIban($iban = null, $calculateBic = false)
    {
        if (is_null($iban)) {
            $this->iban = null;

            return $this;
        } elseif (!is_string($iban)) {
            throw new \InvalidArgumentException('No string neither null given for iban! ' . print_r($iban, true));
        }

        if (!\SEPA::IBAN_check($iban)) {
            throw new InvalidIbanException($iban);
        }

        $this->iban = $iban;

        if ($calculateBic) {
            $this->setBic(\SEPA::IBAN_getBIC($iban));
        }

        return $this;
    }

    /**
     * @param string|null $bic
     *
     * @return $this
     * @throws InvalidBicException
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function setBic($bic = null)
    {
        if (is_null($bic)) {
            $this->bic = null;

            return $this;
        } elseif (!is_string($bic)) {
            throw new \InvalidArgumentException('No string neither null given for bic! ' . print_r($bic, true));
        }

        $len = strlen($bic);
        if (!($len >= 8 && $len <= 11)) {
            throw new \Exception('not the needed length');
        }

        $bicMasked = substr($bic, 0, -3) . 'XXX';
        if (null === \SEPA::BIC_getBankName($bic) && null === \SEPA::BIC_getBankName($bicMasked)) {
            throw new InvalidBicException($bic);
        }

        if (null === $this->bankFlags = \SEPA::BIC_getBankFlags($bic)
                                        && null === $this->bankFlags = \SEPA::BIC_getBankFlags($bicMasked)
        ) {
            throw new InvalidBicException('Unable to get flags');
        }

        $this->bic = $bic;

        return $this;
    }

    /**
     * Generates and sets the IBAN and BIC based on the old data.
     *
     * @param string|integer $bankNumber    Bank Identification Number
     * @param string|integer $accountNumber Account Number
     * @param string         $country       Country Code
     * @param integer        &$status       Status Code
     *
     * @return BankAccount
     */
    public function generateIban($bankNumber, $accountNumber, $country = 'DE', &$status = 0)
    {
        $iban = \SEPA::IBAN_convert($country, $accountNumber, $bankNumber, $status);

        $this->setIban($iban, true);

        return $this;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isAbleTo($type)
    {
        return boolval($this->bankFlags & $type);
    }
}