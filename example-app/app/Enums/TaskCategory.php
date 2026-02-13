<?php

namespace App\Enums;

enum TaskCategory: string
{
    case FRONTEND = 'frontend';
    case BACKEND = 'backend';
    case SERVER = 'server';

    public function label(): string
    {
        return match($this) {
            self::FRONTEND => 'Frontend Developer',
            self::BACKEND => 'Backend Developer',
            self::SERVER => 'Server Administrator',
        };
    }

    public function assignToRole(): UserRole
    {
        return match($this) {
            self::FRONTEND => UserRole::FRONTEND_DEV,
            self::BACKEND => UserRole::BACKEND_DEV,
            self::SERVER => UserRole::SERVER_ADMIN,
        };
    }
}
