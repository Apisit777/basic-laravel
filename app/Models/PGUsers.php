<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PGUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_code',
        'user_name',
        'nickname',
        'e_mail',
        'phone',
        'position',
        'team',
        'e_mail_team',
        'e_mail_group',
        'gmail',
        'anydesk',
        'status'
    ];

    // protected $guarded = [];

    public static function getAllPGUsers() {
        $result = DB::table('pg_users')
            ->select(
                'id',
                'user_code',
                'user_name',
                'nickname',
                'e_mail',
                'phone',
                'position',
                'team',
                'e_mail_team',
                'e_mail_group',
                'gmail',
                'anydesk',
                'status')
            ->get()
            ->toArray();

        return $result;
    }
}
