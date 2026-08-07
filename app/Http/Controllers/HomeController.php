<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HospitalProfile;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\News;
use App\Models\Article;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $profile = HospitalProfile::first();
        $banners = Banner::where('is_active', true)->orderBy('order', 'asc')->get();
        $featuredServices = Service::where('is_active', true)->orderBy('order', 'asc')->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        
        $doctors = Doctor::with(['polyclinic', 'schedules'])
            ->where('is_active', true)
            ->get();
            
        $schedules = DoctorSchedule::with(['doctor', 'polyclinic'])
            ->where('status', 'active')
            ->get();

        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $latestArticles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('public.home', compact(
            'profile',
            'banners',
            'featuredServices',
            'polyclinics',
            'doctors',
            'schedules',
            'latestNews',
            'latestArticles'
        ));
    }
}
