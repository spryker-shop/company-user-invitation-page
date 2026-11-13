<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\CompanyUserInvitationPage\Model\Validator;

use Codeception\Test\Unit;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper\InvitationMapper;
use SprykerShopTest\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageTester;
use SprykerShopTest\Yves\CompanyUserInvitationPage\Helper\InvitationFileHelper;

/**
 * Auto-generated group annotations
 *
 * @group SprykerShopTest
 * @group Yves
 * @group CompanyUserInvitationPage
 * @group Model
 * @group Validator
 * @group ImportFileValidatorTest
 * Add your own group annotations below this line
 */
class ImportFileValidatorTest extends Unit
{
    protected CompanyUserInvitationPageTester $tester;

    public function testIsValidImportFileReturnsTrueWhenFileHasMaximumNumberOfRows(): void
    {
        // Arrange
        $uploadedFile = $this->tester->haveInvitationFile(InvitationFileHelper::MAX_INVITATION_ROWS);

        // Act
        $isValidImportFile = $this->tester->createImportFileValidator()->isValidImportFile($uploadedFile);

        // Assert
        $this->assertTrue($isValidImportFile);
    }

    public function testIsValidImportFileReturnsFalseWhenFileHasMoreThanMaximumNumberOfRows(): void
    {
        // Arrange
        $uploadedFile = $this->tester->haveInvitationFile(InvitationFileHelper::MAX_INVITATION_ROWS + 1);

        // Act
        $isValidImportFile = $this->tester->createImportFileValidator()->isValidImportFile($uploadedFile);

        // Assert
        $this->assertFalse($isValidImportFile);
    }

    public function testIsValidImportFileReturnsFalseWhenFileHasOnlyHeaderRow(): void
    {
        // Arrange
        $uploadedFile = $this->tester->haveInvitationFile(0);

        // Act
        $isValidImportFile = $this->tester->createImportFileValidator()->isValidImportFile($uploadedFile);

        // Assert
        $this->assertFalse($isValidImportFile);
    }

    public function testIsValidImportFileReturnsFalseWhenRequiredColumnIsMissing(): void
    {
        // Arrange
        $headers = array_values(array_diff(InvitationFileHelper::REQUIRED_HEADERS, [InvitationMapper::COLUMN_BUSINESS_UNIT]));
        $uploadedFile = $this->tester->haveInvitationFile(1, $headers);

        // Act
        $isValidImportFile = $this->tester->createImportFileValidator()->isValidImportFile($uploadedFile);

        // Assert
        $this->assertFalse($isValidImportFile);
    }
}
