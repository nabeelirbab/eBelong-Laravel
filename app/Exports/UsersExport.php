<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select(
            'id',
            'first_name',
            'last_name',
            'slug',
            'email',
            'badge_id',
            'expiry_date',
            'location_id',
            'city',
            'state',
            'verification_code',
            'user_verified',
            'remember_token',
            'created_at',
            'updated_at',
            'is_disabled',
            'invited_at',
            'invitation_status',
            'logged_status',
            'last_logged_date',
            'user_type',
            'is_featured',
            'is_agency',
            'agency_id',
            'agency_status',
            'status',
            'is_certified',
            'user_disabled',
            'is_instructor',
            'oauth_id',
            'oauth_type'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Slug',
            'Email',
            'Badge ID',
            'Expiry Date',
            'Location ID',
            'City',
            'State',
            'Verification Code',
            'User Verified',
            'Remember Token',
            'Created At',
            'Updated At',
            'Is Disabled',
            'Invited At',
            'Invitation Status',
            'Logged Status',
            'Last Logged Date',
            'User Type',
            'Is Featured',
            'Is Agency',
            'Agency ID',
            'Agency Status',
            'Status',
            'Is Certified',
            'User Disabled',
            'Is Instructor',
            'OAuth ID',
            'OAuth Type'
        ];
    }
}
