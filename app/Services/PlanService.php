<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }
}