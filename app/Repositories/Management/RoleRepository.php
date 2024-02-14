<?php

namespace App\Repositories\Management;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public const MODEL = Role::class;
}
