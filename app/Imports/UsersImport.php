<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToCollection
{
    use Importable;

    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $headers = $rows->shift();

        foreach ($rows as $row) {
            $row = array_combine($headers->toArray(), $row->toArray());

            if (isset($row['name'], $row['user_code'], $row['email'], $row['phone'], $row['birthday'], $row['type'], $row['status'])) {

                $formattedBirthday = Carbon::instance(Date::excelToDateTimeObject($row['birthday']))->format('m-d-Y');

                $validatedData = validator($row, [
                    'name' => ['required', 'string', 'max:255'],
                    'user_code' => ['required', 'unique:users,user_code'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                    'phone' => ['nullable', 'string', 'max:255', 'regex:/^09\d{9}$/'],
                    'birthday' => ['required', 'date'],
                    'type' => ['required', 'string'],
                    'status' => 'required|string|in:Activate,Deactivate',
                ])->validate();

                User::updateOrCreate(
                    ['user_code' => $validatedData['user_code']],
                    [
                        'name' => $validatedData['name'],
                        'email' => $validatedData['email'],
                        'phone' => $validatedData['phone'],
                        'birthday' => $formattedBirthday,
                        'type' => $validatedData['type'],
                        'status' => $validatedData['status'],
                        'password' => Hash::make($formattedBirthday),
                    ]
                );
            } else {
                dd('Missing keys in row: ', $row);
            }
        }
    }
}
