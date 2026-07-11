<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class ActivityLog extends BaseController
{
    public function index()
    {
        $logModel = new ActivityLogModel();

        $data = [
            'title' => 'Activity Log',
            'logs' => $logModel
                ->orderBy('id_log', 'DESC')
                ->findAll()
        ];

        return view('activity_log/index', $data);
    }
}