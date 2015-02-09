<?php

namespace ChrKo\SEPA\Drivers\libsepa;

use ChrKo\SEPA\Abstracts\DirectDebit as AbstractDirectDebit;
use ChrKo\SEPA\Exceptions\InvalidStateException;
use ChrKo\SEPA\Interfaces\Creditor as ICreditor;
use ChrKo\SEPA\Interfaces\Mandate as IMandate;

/**
 * Class DirectDebit
 * @package ChrKo\SEPA\Drivers\libsepa
 */
class DirectDebit
    extends AbstractDirectDebit
{
    /**
     * @var \SEPA
     */
    protected $libsepa;

    public function __construct(ICreditor $creditor)
    {
        $this->libsepa = new \SEPA(BankAccount::DIRECT_DEBIT);
        parent::__construct($creditor);
    }

    /**
     * @inheritdoc
     */
    public function setCreditor(ICreditor $creditor)
    {
        parent::setCreditor($creditor);

        $this->libsepa->setName($this->creditor->getName());
        $this->libsepa->setCreditorIdentifier($this->creditor->getCreditorIdentifier());
        $this->libsepa->setIBAN($this->creditor->getIban());
        $this->libsepa->setBIC($this->creditor->getBic());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setDueDate($dueDate)
    {
        parent::setDueDate($dueDate);

        $this->libsepa->setDate($this->dueDate->format('Y-m-d'));

        return $this;
    }

    /**
     * @return string
     * @throws InvalidStateException
     */
    public function getXml()
    {
        foreach ($this->mandates as $mandate) {
            $tx = [
                'name'   => $mandate->getName(),
                'iban'   => $mandate->getIban(),
                'bic'    => $mandate->getBic(),
                'mref'   => $mandate->getMandateReference(),
                'mdate'  => $mandate->getMandateDate()->format('Y-m-d'),
                'amount' => $this->amount
            ];

            if ($this->reference != null) {
                $tx['ref'] = $this->reference;
            }

            switch ($mandate->getState()) {
                case IMandate::FIRST:
                    $tx['seq'] = 'FRST';
                    break;
                case IMandate::RECURRING:
                    $tx['seq'] = 'RCUR';
                    break;
                case IMandate::LAST:
                    $tx['seq'] = 'FNAL';
                    break;
                case IMandate::ONE_OFF:
                    $tx['seq'] = 'OOFF';
                    break;
                default:
                    throw new InvalidStateException('No valid state in $mandate');
            }

            if ($mandate->isType(IMandate::RECURRING) && $mandate->getOldMandate() instanceof IMandate) {
                if ($mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() != $mandate->getOldMandate()->getBic()
                ) {
                    $tx['smnda'] = 1;
                }

                if ($mandate->getState() != IMandate::FIRST
                    && $mandate->getMandateReference() != $mandate->getOldMandate()->getMandateReference()
                ) {
                    $tx['old_mref'] = $mandate->getOldMandate()->getMandateReference();
                }

                if ($mandate->getState() != IMandate::FIRST
                    && $mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() == $mandate->getOldMandate()->getBic()
                ) {
                    $tx['old_iban'] = $mandate->getOldMandate()->getIban();
                }
            }

            $this->libsepa->add($tx);
        }

        return $this->libsepa->toXML();
    }
}