<?php

namespace App\Contracts;

interface UserContract
{
    public const TABLE = 'users';
    public const FIELD_ID = 'id';
    public const FIELD_EMAIL = 'email';
    public const FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_REMEMBER_TOKEN = 'remember_token';
    public const FIELD_PHOTO = 'photo';
    public const FIELD_STATUS = 'status';

    // Статусы по которым вход в аккаунт запрещен
    public const STATUS_LIST = [
        1 => 'Уволен',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
        self::FIELD_EMAIL_VERIFIED_AT
    ];

    public const HIDDEN_FIELDS = [
        self::FIELD_PASSWORD,
        self::FIELD_REMEMBER_TOKEN
    ];

    public const CASTS_FIELDS = [
        self::FIELD_EMAIL_VERIFIED_AT => 'datetime',
        self::FIELD_PASSWORD => 'hashed',
    ];
}
