<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Shared\CompanyUserInvitationPage;

interface CompanyUserInvitationPageConstants
{
    public const INVITATION_FILE_DELIMITER = 'COMPANY_USER_INVITATION:INVITATION_FILE_DELIMITER';
    
    public const ID_COMPANY_USER_INVITATION = 'id';
    public const INVITATION_HASH = 'hash';
    public const ROUTE_INVITATION_ACCEPT = 'invitation/accept';
    public const IMPORT_ERRORS_FILE_PATH = '/tmp';
    public const INVITATION_SESSION_ID = 'COMPANY_USER_INVITATION';
    public const IMPORT_ERRORS_FILE_PREFIX = '_IMPORT_ERRORS_FILE_';
    public const INVITATION_IMPORT_ERRORS_FILE = 'INVITATION_IMPORT_ERRORS_FILE';
}
