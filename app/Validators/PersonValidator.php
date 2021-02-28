<?php

namespace Jas\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

/**
 * Class PersonValidator
 * @package Jas\Validators
 */
class PersonValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|between:3,200',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|between:3,200',
        ],
    ];
}
