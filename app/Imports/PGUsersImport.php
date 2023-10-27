<?php

namespace App\Imports;

use App\Models\PGUsers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PGUsersImport implements ToModel, WithHeadingRow
{
    private $branch;

    public function __construct(string $branch = null)
    {
        $this->branch = $branch;
    }

    public function getDateFromxlxs($date)
    {
        return is_integer($date) || is_float($date) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($date))->format('Y-m-d') : $date;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd(new PGUsers);
        // PGUsers::where('id')->update($saveData);

        return new PGUsers([
            'user_code' => $row['user_code'],
            'user_name' => $row['user_name'],
            'nickname' => $row['nickname'],
            'e_mail' => $row['e_mail'],
            'phone' => $row['phone'],
            'position' => $row['position'],
            'team' => $row['team'],
            'e_mail_team' => $row['e_mail_team'],
            'e_mail_group' => $row['e_mail_group'],
            'gmail' => $row['gmail'],
            'anydesk' => $row['anydesk'],
            'status' => $row['status']
        ]);
    }
}
