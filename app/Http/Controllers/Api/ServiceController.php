<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get(['id', 'title', 'description', 'icon']);
    }
}
