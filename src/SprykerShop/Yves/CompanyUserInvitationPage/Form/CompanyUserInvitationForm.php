<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @method \SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageFactory getFactory()
 * @method \SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageConfig getConfig()
 */
class CompanyUserInvitationForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_INVITATIONS_LIST = 'invitations_list';

    /**
     * @var string
     */
    protected const VALIDATION_NOT_BLANK_MESSAGE = 'validation.not_blank';

    protected const string VALIDATION_INVALID_FILE_MESSAGE = 'company.user.invitation.import.file.invalid';

    protected const string INVITATIONS_FILE_MAX_SIZE = '500k';

    protected const array INVITATIONS_FILE_MIME_TYPES = ['text/csv', 'text/plain', 'application/csv', 'application/vnd.ms-excel'];

    public function getName(): string
    {
        return 'companyUserInvitationForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(static::FIELD_INVITATIONS_LIST, FileType::class, [
            'label' => 'company.user.invitation.file',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createFileConstraint(),
                new Callback(
                    callback: function ($uploadedFile, ExecutionContextInterface $context) {
                        if ($uploadedFile && !$this->getFactory()->createImportFileValidator()->isValidImportFile($uploadedFile)) {
                            $context->buildViolation(static::VALIDATION_INVALID_FILE_MESSAGE)->addViolation();
                        }
                    },
                ),
            ],
        ]);
    }

    protected function createFileConstraint(): File
    {
        return new File(
            maxSize: static::INVITATIONS_FILE_MAX_SIZE,
            maxSizeMessage: static::VALIDATION_INVALID_FILE_MESSAGE,
            mimeTypes: static::INVITATIONS_FILE_MIME_TYPES,
            mimeTypesMessage: static::VALIDATION_INVALID_FILE_MESSAGE,
        );
    }

    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank(['message' => static::VALIDATION_NOT_BLANK_MESSAGE]);
    }
}
