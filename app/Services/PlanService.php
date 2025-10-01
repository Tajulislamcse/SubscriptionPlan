<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class PlanService extends BaseService
{
    protected $fileUploadService;

    public function __construct(
        Plan $model,
        FileUploadService $fileUploadService,
    ) {
        parent::__construct($model);
        $this->fileUploadService = $fileUploadService;
    }

    public function createOrUpdate($request, $id = null)
    {
        $data = $request->all();

        if ($id) {

            $plan = $this->get($id);


            if ($request->hasFile('image')) {

                if ($plan->image) {
                    $this->fileUploadService->delete($plan->image);
                }

                $data['image'] = $this->fileUploadService->uploadFile(
                    $request,
                    field_name: 'image',
                    upload_path: Plan::FILE_STORE_PATH
                );
            } else {
                unset($data['image']);
            }

            $plan->update($data);

            return $plan;
        } else {
            if ($request->hasFile('image')) {
                $data['image'] = $this->fileUploadService->uploadFile(
                    $request,
                    field_name: 'image',
                    upload_path: Plan::FILE_STORE_PATH
                );
            }

            $plan = $this->model::create($data);

            return $plan;
        }
    }
}
