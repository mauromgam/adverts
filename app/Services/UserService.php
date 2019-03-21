<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements Service
{
    /**
     * Saves a CSV file content in the Database prior to process it
     *
     * @param $csv
     * @return array
     */
    public function upload($csv)
    {
        $log = [];

        $userArray = [
            'name'       => $csv->username,
            'email'      => $csv->email,
            'password'   => $password = Hash::make('test123'),
            'is_enabled' => 1
        ];

        try {
            $validator = Validator::make((array)$csv, [
                "username" => "required|string",
                "email"    => "required|email",
            ]);
            $validator->validate();

            /** User|null|true $user */
            if ($user = User::where('email', $csv->email)->first()) {
                \Log::error("User already exists - User ID: " . $user->id);
                $log['errors'][] = 'User already exists';
            } else {
                $user = User::create($userArray);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error("data: ", $userArray);
            $log['errors'][] = $e->getMessage();
        }

        return $log;
    }
}
