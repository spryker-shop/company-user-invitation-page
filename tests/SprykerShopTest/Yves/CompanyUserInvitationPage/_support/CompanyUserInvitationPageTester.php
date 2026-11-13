<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\CompanyUserInvitationPage;

use Codeception\Actor;
use Codeception\Stub;
use SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageConfig;
use SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageFactory;
use SprykerShop\Yves\CompanyUserInvitationPage\Form\CompanyUserInvitationForm;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader\CsvInvitationReader;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Validator\ImportFileValidator;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Validator\ImportFileValidatorInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class CompanyUserInvitationPageTester extends Actor
{
    use _generated\CompanyUserInvitationPageTesterActions;

    public function createImportFileValidator(): ImportFileValidatorInterface
    {
        return new ImportFileValidator(new CsvInvitationReader(new CompanyUserInvitationPageConfig()));
    }

    /**
     * @return \Symfony\Component\Form\FormInterface<mixed>
     */
    public function createCompanyUserInvitationForm(): FormInterface
    {
        $companyUserInvitationForm = new CompanyUserInvitationForm();
        $companyUserInvitationForm->setFactory(Stub::make(CompanyUserInvitationPageFactory::class, [
            'createImportFileValidator' => $this->createImportFileValidator(),
        ]));

        return Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->addType($companyUserInvitationForm)
            ->getFormFactory()
            ->create(CompanyUserInvitationForm::class);
    }
}
