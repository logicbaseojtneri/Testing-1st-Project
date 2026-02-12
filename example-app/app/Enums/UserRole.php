<?php

namespace App\Enums;

enum UserRole: string
{
    case CUSTOMER = 'customer';
    case FRONTEND_DEV = 'frontend_dev';
    case BACKEND_DEV = 'backend_dev';
    case SERVER_ADMIN = 'server_admin';

    public function label(): string
    {
        return match($this) {
            self::CUSTOMER => 'Customer',
            self::FRONTEND_DEV => 'Frontend Developer',
            self::BACKEND_DEV => 'Backend Developer',
            self::SERVER_ADMIN => 'Server Administrator',
        };
    }

    public static function developerRoles(): array
    {
        return [
            self::FRONTEND_DEV,
            self::BACKEND_DEV,
            self::SERVER_ADMIN,
        ];
    }
}
