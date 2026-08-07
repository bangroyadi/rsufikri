<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Service;
use App\Models\News;
use App\Models\Article;
use App\Models\Polyclinic;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDoctors = Doctor::count();
        $totalSchedules = DoctorSchedule::count();
        $totalServices = Service::count();
        $totalNews = News::count();
        $totalArticles = Article::count();
        $totalPolyclinics = Polyclinic::count();

        return view('admin.dashboard', compact(
            'totalDoctors',
            'totalSchedules',
            'totalServices',
            'totalNews',
            'totalArticles',
            'totalPolyclinics'
        ));
    }
}
