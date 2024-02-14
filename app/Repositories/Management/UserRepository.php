<?php

namespace App\Repositories\Management;

use App\Models\User;
use App\Notifications\Auth\Notifications\UserRegistered;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    public const MODEL = User::class;

    /**
     * Create user and send mail notification
     * @param array $input
     * @return mixed
     */
    public function create(array $input)
    {
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
        $input = array_merge($input, ['password' => $hashedPassword]);

        $createdUser = $this->query()->create($input);

        Password::sendResetLink(['email' => $input['email']],
            function ($user, $token) use ($createdUser, $password) {
                $createdUser->notify(new UserRegistered($token, $password));
            });

        $createdUser->assignRole($input['role'], $input['guard']);

        return $createdUser;
    }

    public function update(Model $model, array $input)
    {
        /** Set role */
        if (isset($input['role'])) {
            if (!$model->hasRole($input['role'])) {
                $model->syncRoles([]);
                $model->assignRole($input['role'], $input['guard']);
            }
        }

        return $model->update($input);
    }
}
