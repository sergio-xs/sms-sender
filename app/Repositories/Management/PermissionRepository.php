<?php

namespace App\Repositories\Management;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public const MODEL = Permission::class;
}
