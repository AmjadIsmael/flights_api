<?php

/*namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
   /* public function collection()
    {
        return User::all();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    /*public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('Y-m-d H:i:s'),
            $user->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return array
     */
   /* public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Created At', 'Updated At'];
    }
}
