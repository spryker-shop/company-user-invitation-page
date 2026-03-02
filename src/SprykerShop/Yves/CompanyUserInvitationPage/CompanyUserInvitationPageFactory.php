<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToCompanyUserInvitationClientInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToCustomerClientInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToSessionClientInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Form\FormFactory;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Error\ImportErrorHandler;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Error\ImportErrorHandlerInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper\InvitationMapper;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper\InvitationMapperInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader\CsvInvitationReader;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader\InvitationReaderInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Validator\ImportFileValidator;

/**
 * @method \SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageConfig getConfig()
 */
class CompanyUserInvitationPageFactory extends AbstractFactory
{
    public function createCompanyUserInvitationPageFormFactory(): FormFactory
    {
        return new FormFactory();
    }

    public function createCsvInvitationReader(): InvitationReaderInterface
    {
        return new CsvInvitationReader(
            $this->getConfig(),
        );
    }

    public function createInvitationMapper(): InvitationMapperInterface
    {
        return new InvitationMapper(
            $this->getCustomerClient(),
        );
    }

    public function createImportErrorsHandler(): ImportErrorHandlerInterface
    {
        return new ImportErrorHandler(
            $this->getSessionClient(),
        );
    }

    /**
     * @return \SprykerShop\Yves\CompanyUserInvitationPage\Model\Validator\ImportFileValidatorInterface
     */
    public function createImportFileValidator()
    {
        return new ImportFileValidator(
            $this->createCsvInvitationReader(),
        );
    }

    public function getCompanyUserInvitationClient(): CompanyUserInvitationPageToCompanyUserInvitationClientInterface
    {
        return $this->getProvidedDependency(CompanyUserInvitationPageDependencyProvider::CLIENT_COMPANY_USER_INVITATION);
    }

    public function getCustomerClient(): CompanyUserInvitationPageToCustomerClientInterface
    {
        return $this->getProvidedDependency(CompanyUserInvitationPageDependencyProvider::CLIENT_CUSTOMER);
    }

    public function getSessionClient(): CompanyUserInvitationPageToSessionClientInterface
    {
        return $this->getProvidedDependency(CompanyUserInvitationPageDependencyProvider::CLIENT_SESSION);
    }
}
