<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client;

use Generated\Shared\Transfer\CompanyUserInvitationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationGetCollectionRequestTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationImportRequestTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationImportResponseTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationSendBatchResponseTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationSendRequestTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationSendResponseTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationUpdateStatusRequestTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationUpdateStatusResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserInvitationPageToCompanyUserInvitationClientBridge implements CompanyUserInvitationPageToCompanyUserInvitationClientInterface
{
    /**
     * @var \Spryker\Client\CompanyUserInvitation\CompanyUserInvitationClientInterface
     */
    protected $companyUserInvitationClient;

    /**
     * @param \Spryker\Client\CompanyUserInvitation\CompanyUserInvitationClientInterface $companyUserInvitationClient
     */
    public function __construct($companyUserInvitationClient)
    {
        $this->companyUserInvitationClient = $companyUserInvitationClient;
    }

    public function importCompanyUserInvitations(
        CompanyUserInvitationImportRequestTransfer $companyUserInvitationImportRequestTransfer
    ): CompanyUserInvitationImportResponseTransfer {
        return $this->companyUserInvitationClient->importCompanyUserInvitations($companyUserInvitationImportRequestTransfer);
    }

    public function getCompanyUserInvitationCollection(
        CompanyUserInvitationGetCollectionRequestTransfer $companyUserInvitationGetCollectionRequestTransfer
    ): CompanyUserInvitationCollectionTransfer {
        return $this->companyUserInvitationClient->getCompanyUserInvitationCollection($companyUserInvitationGetCollectionRequestTransfer);
    }

    public function sendCompanyUserInvitation(
        CompanyUserInvitationSendRequestTransfer $companyUserInvitationSendRequestTransfer
    ): CompanyUserInvitationSendResponseTransfer {
        return $this->companyUserInvitationClient->sendCompanyUserInvitation($companyUserInvitationSendRequestTransfer);
    }

    public function sendCompanyUserInvitations(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserInvitationSendBatchResponseTransfer {
        return $this->companyUserInvitationClient->sendCompanyUserInvitations($companyUserTransfer);
    }

    public function updateCompanyUserInvitationStatus(
        CompanyUserInvitationUpdateStatusRequestTransfer $companyUserInvitationUpdateStatusRequestTransfer
    ): CompanyUserInvitationUpdateStatusResponseTransfer {
        return $this->companyUserInvitationClient->updateCompanyUserInvitationStatus($companyUserInvitationUpdateStatusRequestTransfer);
    }

    public function getCompanyUserInvitationByHash(
        CompanyUserInvitationTransfer $companyUserInvitationTransfer
    ): CompanyUserInvitationTransfer {
        return $this->companyUserInvitationClient->getCompanyUserInvitationByHash($companyUserInvitationTransfer);
    }
}
