<?php

namespace App\Modules\User\Infrastructure\Http\Controller;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {

        return $this->rendering(
            view: 'User/Dashboard',
            data: [
            ], breadcrumbs: [
            ['label' => 'Trang chủ'],
        ]);
    }
}
