<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class PlanService extends BaseService
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }
}
