<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case DEVELOPER = 'developer';
    case FRONTEND = 'frontend';
    case BACKEND = 'backend';
    case SERVER_ADMIN = 'server_admin';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::CUSTOMER => 'Customer',
            self::DEVELOPER => 'Developer',
            self::FRONTEND => 'Frontend Developer',
            self::BACKEND => 'Backend Developer',
            self::SERVER_ADMIN => 'Server Administrator',
        };
    }

    public static function developerRoles(): array
    {
        return [
            self::DEVELOPER,
            self::FRONTEND,
            self::BACKEND,
            self::SERVER_ADMIN,
        ];
    }

    public function canCreateTask(): bool
    {
        return in_array($this, [self::DEVELOPER, self::FRONTEND, self::BACKEND, self::CUSTOMER]);
    }

    public function canCreateProject(): bool
    {
        return in_array($this, [self::DEVELOPER, self::FRONTEND, self::BACKEND, self::CUSTOMER]);
    }

    public function canRegisterUsers(): bool
    {
        return $this === self::ADMIN;
    }

    public function canManageUsers(): bool
    {
        return $this === self::ADMIN;
    }

    public function canDeleteProject(): bool
    {
        return in_array($this, [self::ADMIN, self::DEVELOPER, self::BACKEND]);
    }

    public function canDeleteTask(): bool
    {
        return in_array($this, [self::ADMIN, self::DEVELOPER, self::BACKEND]);
    }
}
