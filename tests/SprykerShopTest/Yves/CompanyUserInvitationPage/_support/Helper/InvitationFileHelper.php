<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\CompanyUserInvitationPage\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper\InvitationMapper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class InvitationFileHelper extends Module
{
    public const int MAX_INVITATION_ROWS = 100;

    public const string INVITATION_FILE_NAME = 'invitations.csv';

    public const array REQUIRED_HEADERS = [
        InvitationMapper::COLUMN_FIRST_NAME,
        InvitationMapper::COLUMN_LAST_NAME,
        InvitationMapper::COLUMN_EMAIL,
        InvitationMapper::COLUMN_BUSINESS_UNIT,
    ];

    /**
     * @var list<string>
     */
    protected array $invitationFilePaths = [];

    /**
     * @param list<string> $headers
     */
    public function haveInvitationFile(int $rowCount, array $headers = self::REQUIRED_HEADERS, string $firstName = 'John'): UploadedFile
    {
        $rows = [implode(',', $headers)];

        for ($i = 0; $i < $rowCount; $i++) {
            $rows[] = implode(',', [$firstName, 'Doe', sprintf('john.doe.%d@spryker.com', $i), 'Business unit']);
        }

        return $this->haveUploadedFile(implode("\n", $rows) . "\n");
    }

    public function haveUploadedFile(string $content): UploadedFile
    {
        $invitationFilePath = (string)tempnam(sys_get_temp_dir(), 'invitations');
        file_put_contents($invitationFilePath, $content);
        $this->invitationFilePaths[] = $invitationFilePath;

        return new UploadedFile($invitationFilePath, static::INVITATION_FILE_NAME, null, null, true);
    }

    public function _after(TestInterface $test): void
    {
        foreach ($this->invitationFilePaths as $invitationFilePath) {
            if (is_file($invitationFilePath)) {
                unlink($invitationFilePath);
            }
        }

        $this->invitationFilePaths = [];
    }
}
