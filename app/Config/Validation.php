<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $userStoreRules = [
        'first_name' => [
            'label' => 'Labels.user.first_name',
            'rules' => [
                'required',
            ],
            'errors' => [
                'required' => 'Rules.required',
            ],
        ],
        'last_name' => [
            'label' => 'Labels.user.last_name',
            'rules' => [
                'required',
            ],
            'errors' => [
                'required' => 'Rules.required',
            ],
        ],
        'mobile' => [
            'label' => 'Labels.user.mobile',
            'rules' => [
                'required',
                'is_unique[users.mobile]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'is_unique' => 'Rules.user.mobile.unique',
            ],
        ],
        'username' => [
            'label' => 'Labels.user.username',
            'rules' => [
                'required',
                'is_unique[users.username]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'is_unique' => 'Rules.user.username.unique',
            ],
        ],
        'email' => [
            'label' => 'Labels.user.email',
            'rules' => [
                'required',
                'valid_email',
                'is_unique[users.email]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'valid_email' => 'Rules.valid_email',
                'is_unique' => 'Rules.user.email.unique',
            ],
        ],
        'password' => [
            'label' => 'Labels.user.password',
            'rules' => [
                'required',
            ],
            'errors' => [
                'required' => 'Rules.required',
            ],
        ],
        'password_confirm' => [
            'label' => 'Labels.user.password_confirm',
            'rules' => [
                'required_with[password]',
                'matches[password]',
            ],
            'errors' => [
                'required_with' => 'Rules.user.password_confirm.required_with',
                'matches' => 'Rules.user.password_confirm.matches',
            ],
        ],
    ];
    public array $userUpdateRules = [
        'id' => 'is_natural_no_zero',
        'first_name' => [
            'label' => 'Labels.user.first_name',
            'rules' => [
                'required',
            ],
            'errors' => [
                'required' => 'Rules.required',
            ],
        ],
        'last_name' => [
            'label' => 'Labels.user.last_name',
            'rules' => [
                'required',
            ],
            'errors' => [
                'required' => 'Rules.required',
            ],
        ],
        'mobile' => [
            'label' => 'Labels.user.mobile',
            'rules' => [
                'required',
                'is_unique[users.mobile,id,{id}]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'is_unique' => 'Rules.user.mobile.unique',
            ],
        ],
        'username' => [
            'label' => 'Labels.user.username',
            'rules' => [
                'required',
                'is_unique[users.username,id,{id}]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'is_unique' => 'Rules.user.username.unique',
            ],
        ],
        'email' => [
            'label' => 'Labels.user.email',
            'rules' => [
                'required',
                'valid_email',
                'is_unique[users.email,id,{id}]',
            ],
            'errors' => [
                'required' => 'Rules.required',
                'valid_email' => 'Rules.valid_email',
                'is_unique' => 'Rules.user.email.unique',
            ],
        ],
        'password' => [
            'label' => 'Labels.user.password',
            'rules' => [
                'permit_empty',
            ],
        ],
        'password_confirm' => [
            'label' => 'Labels.user.password_confirm',
            'rules' => [
                'permit_empty',
                'matches[password]',
            ],
            'errors' => [
                'required_with' => 'Rules.user.password_confirm.required_with',
                'matches' => 'Rules.user.password_confirm.matches',
            ],
        ],
    ];
}
