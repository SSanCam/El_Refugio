<?php
namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'] ?? 'user',
            'phone' => $data['phone'] ?? null,
            'dni' => $data['dni'] ?? null,
            'active' => $data['active'] ?? true,
        ]);
    }

    public function activateUser(User $user): void
    {
        $user->update(['active' => true]);
    }

    public function deactivateUser(User $user): void
    {
        $user->update(['active' => false]);
    }
}
