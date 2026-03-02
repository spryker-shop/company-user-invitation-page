<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper;

use Generated\Shared\Transfer\CompanyUserInvitationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationTransfer;
use Iterator;
use SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToCustomerClientInterface;

class InvitationMapper implements InvitationMapperInterface
{
    /**
     * @var string
     */
    public const COLUMN_EMAIL = 'email';

    /**
     * @var string
     */
    public const COLUMN_BUSINESS_UNIT = 'business_unit';

    /**
     * @var string
     */
    public const COLUMN_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const COLUMN_FIRST_NAME = 'first_name';

    /**
     * @var \SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToCustomerClientInterface
     */
    protected $customerClient;

    public function __construct(
        CompanyUserInvitationPageToCustomerClientInterface $customerClient
    ) {
        $this->customerClient = $customerClient;
    }

    public function mapInvitations(Iterator $invitations): CompanyUserInvitationCollectionTransfer
    {
        $idCompanyUser = $this->customerClient->getCustomer()->getCompanyUserTransfer()->getIdCompanyUser();
        $companyUserInvitationCollectionTransfer = new CompanyUserInvitationCollectionTransfer();
        foreach ($invitations as $invitation) {
            $companyUserInvitationTransfer = $this->getCompanyUserInvitationTransfer($invitation);
            $companyUserInvitationTransfer->setFkCompanyUser($idCompanyUser);
            $companyUserInvitationCollectionTransfer->addCompanyUserInvitation($companyUserInvitationTransfer);
        }

        return $companyUserInvitationCollectionTransfer;
    }

    protected function getCompanyUserInvitationTransfer(array $record): CompanyUserInvitationTransfer
    {
        return (new CompanyUserInvitationTransfer())
            ->setFirstName($record[static::COLUMN_FIRST_NAME])
            ->setLastName($record[static::COLUMN_LAST_NAME])
            ->setEmail($record[static::COLUMN_EMAIL])
            ->setCompanyBusinessUnitName($record[static::COLUMN_BUSINESS_UNIT]);
    }
}
