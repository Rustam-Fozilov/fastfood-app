<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Email_verified_at',
            'Password',
            'Remember_token',
            'Is_admin',
            'Created_at',
            'Updated_at',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->email_verified_at,
            $user->password,
            $user->remember_token,
            $user->is_admin,
            $user->created_at,
            $user->updated_at,
        ];
    }
}
