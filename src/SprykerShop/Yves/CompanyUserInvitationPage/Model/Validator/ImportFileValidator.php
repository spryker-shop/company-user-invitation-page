<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Model\Validator;

use Iterator;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Mapper\InvitationMapper;
use SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader\InvitationReaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class ImportFileValidator implements ImportFileValidatorInterface
{
    protected const int MAX_INVITATION_ROWS = 100;

    /**
     * @var \SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader\InvitationReaderInterface
     */
    protected $invitationReader;

    public function __construct(InvitationReaderInterface $invitationReader)
    {
        $this->invitationReader = $invitationReader;
    }

    public function isValidImportFile(UploadedFile $uploadedFile): bool
    {
        try {
            return $this->isValidInvitationData($this->invitationReader->getData($uploadedFile->getPathname()));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @param \Iterator<int, array<string, mixed>> $records
     */
    protected function isValidInvitationData(Iterator $records): bool
    {
        $records->rewind();

        if (!$records->valid() || !$this->hasRequiredHeaders(array_keys($records->current()))) {
            return false;
        }

        $rowCount = 1;
        $records->next();

        while ($records->valid()) {
            $rowCount++;

            if ($rowCount > static::MAX_INVITATION_ROWS) {
                return false;
            }

            $records->next();
        }

        return true;
    }

    /**
     * @param array<string> $headers
     */
    protected function hasRequiredHeaders(array $headers): bool
    {
        return !array_diff([
            InvitationMapper::COLUMN_FIRST_NAME,
            InvitationMapper::COLUMN_LAST_NAME,
            InvitationMapper::COLUMN_EMAIL,
            InvitationMapper::COLUMN_BUSINESS_UNIT,
        ], $headers);
    }
}
