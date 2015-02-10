<?php

namespace ChrKo\SEPA\Drivers;

use ChrKo\SEPA\Interfaces\Driver;

use ChrKo\SEPA\DirectDebit;
use ChrKo\SEPA\Mandate;

use ChrKo\SEPA\Exceptions\InvalidStateException;

/**
 * Class libsepa
 * @package ChrKo\SEPA\Drivers
 */
class libsepa
    implements Driver
{
    /**
     * @param string $bankNumber
     * @param string $accountNumber
     * @param string $country
     * @param int    $status
     *
     * @return string
     */
    public function generateIban($bankNumber, $accountNumber, $country = 'DE', &$status = 0)
    {
        return \SEPA::IBAN_convert($country, $accountNumber, $bankNumber, $status);
    }

    /**
     * @param $iban
     *
     * @return string
     */
    public function getBicForIban($iban)
    {
        return \SEPA::IBAN_getBIC($iban);
    }

    public function isBicValid($bic)
    {
        $bicMasked = substr($bic, 0, -3) . 'XXX';
        if (null === \SEPA::BIC_getBankName($bic) && null === \SEPA::BIC_getBankName($bicMasked)) {
            return false;
        }

        return true;
    }

    /**
     * @param DirectDebit $directDebit
     *
     * @return mixed
     * @throws InvalidStateException
     */
    public function getDirectDebitXml(DirectDebit $directDebit)
    {
        $libsepa = new \SEPA(SEPA_MSGTYPE_DDI);

        $libsepa->setName($directDebit->getCreditor()->getName());
        $libsepa->setCreditorIdentifier($directDebit->getCreditor()->getCreditorIdentifier());
        $libsepa->setIBAN($directDebit->getCreditor()->getIban());
        $libsepa->setBIC($directDebit->getCreditor()->getBic());

        $libsepa->setDate($directDebit->getDueDate()->format('Y-m-d'));

        foreach ($directDebit->getMandates() as $mandate) {
            $tx = [
                'name'   => $mandate->getName(),
                'iban'   => $mandate->getIban(),
                'bic'    => $mandate->getBic(),
                'mref'   => $mandate->getMandateReference(),
                'mdate'  => $mandate->getMandateDate()->format('Y-m-d'),
                'amount' => $directDebit->getAmount()
            ];

            if ($directDebit->getReference() != null) {
                $tx['ref'] = $directDebit->getReference();
            }

            switch ($mandate->getState()) {
                case Mandate::FIRST:
                    $tx['seq'] = 'FRST';
                    break;
                case Mandate::RECURRING:
                    $tx['seq'] = 'RCUR';
                    break;
                case Mandate::LAST:
                    $tx['seq'] = 'FNAL';
                    break;
                case Mandate::ONE_OFF:
                    $tx['seq'] = 'OOFF';
                    break;
                default:
                    throw new InvalidStateException('No valid state in $mandate');
            }

            if ($mandate->isType(Mandate::RECURRING) && $mandate->getOldMandate() instanceof Mandate) {
                if ($mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() != $mandate->getOldMandate()->getBic()
                ) {
                    $tx['smnda'] = 1;
                }

                if ($mandate->getState() != Mandate::FIRST
                    && $mandate->getMandateReference() != $mandate->getOldMandate()->getMandateReference()
                ) {
                    $tx['old_mref'] = $mandate->getOldMandate()->getMandateReference();
                }

                if ($mandate->getState() != Mandate::FIRST
                    && $mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() == $mandate->getOldMandate()->getBic()
                ) {
                    $tx['old_iban'] = $mandate->getOldMandate()->getIban();
                }
            }

            $libsepa->add($tx);
        }

        return $libsepa->toXML();
    }
}
