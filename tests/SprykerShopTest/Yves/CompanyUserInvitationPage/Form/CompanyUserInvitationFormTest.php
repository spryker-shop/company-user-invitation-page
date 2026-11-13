<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\CompanyUserInvitationPage\Form;

use Codeception\Test\Unit;
use SprykerShop\Yves\CompanyUserInvitationPage\Form\CompanyUserInvitationForm;
use SprykerShopTest\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageTester;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerShopTest
 * @group Yves
 * @group CompanyUserInvitationPage
 * @group Form
 * @group CompanyUserInvitationFormTest
 * Add your own group annotations below this line
 */
class CompanyUserInvitationFormTest extends Unit
{
    protected const int MAX_FILE_SIZE_IN_BYTES = 500000;

    protected CompanyUserInvitationPageTester $tester;

    public function testFormIsValidWhenCsvFileIsSubmitted(): void
    {
        // Arrange
        $companyUserInvitationForm = $this->tester->createCompanyUserInvitationForm();

        // Act
        $companyUserInvitationForm->submit([CompanyUserInvitationForm::FIELD_INVITATIONS_LIST => $this->tester->haveInvitationFile(1)]);

        // Assert
        $this->assertTrue($companyUserInvitationForm->isValid());
    }

    public function testFormHasFileConstraintViolationWhenFileIsLargerThanMaximumSize(): void
    {
        // Arrange
        $companyUserInvitationForm = $this->tester->createCompanyUserInvitationForm();
        $uploadedFile = $this->tester->haveInvitationFile(1, firstName: str_repeat('a', static::MAX_FILE_SIZE_IN_BYTES));

        // Act
        $companyUserInvitationForm->submit([CompanyUserInvitationForm::FIELD_INVITATIONS_LIST => $uploadedFile]);

        // Assert
        $this->assertTrue($this->hasFileConstraintViolation($companyUserInvitationForm));
    }

    public function testFormHasFileConstraintViolationWhenFileHasUnsupportedMimeType(): void
    {
        // Arrange
        $companyUserInvitationForm = $this->tester->createCompanyUserInvitationForm();
        $uploadedFile = $this->tester->haveUploadedFile(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII='));

        // Act
        $companyUserInvitationForm->submit([CompanyUserInvitationForm::FIELD_INVITATIONS_LIST => $uploadedFile]);

        // Assert
        $this->assertTrue($this->hasFileConstraintViolation($companyUserInvitationForm));
    }

    /**
     * @param \Symfony\Component\Form\FormInterface<mixed> $companyUserInvitationForm
     */
    protected function hasFileConstraintViolation(FormInterface $companyUserInvitationForm): bool
    {
        foreach ($companyUserInvitationForm->get(CompanyUserInvitationForm::FIELD_INVITATIONS_LIST)->getErrors(true) as $formError) {
            $constraintViolation = $formError instanceof FormError ? $formError->getCause() : null;

            if ($constraintViolation instanceof ConstraintViolationInterface && $constraintViolation->getConstraint() instanceof File) {
                return true;
            }
        }

        return false;
    }
}
