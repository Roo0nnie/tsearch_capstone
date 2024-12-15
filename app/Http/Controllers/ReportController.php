<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imrad;
use App\Models\Admin;
use App\Models\GuestAccount;
use App\Models\ImradMetric;
use App\Models\LogHistory;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

        public function reportsBarSDG()
    {
        $SDG_list = [
            '1' => 'No Poverty',
            '2' => 'Zero Hunger',
            '3' => 'Good Health and Well-being',
            '4' => 'Quality Education',
            '5' => 'Gender Equality',
            '6' => 'Clean Water and Sanitation',
            '7' => 'Affordable and Clean Energy',
            '8' => 'Decent Work and Economic Growth',
            '9' => 'Industry, Innovation and Infrastructure',
            '10' => 'Reduced Inequality',
            '11' => 'Sustainable Cities and Communities',
            '12' => 'Responsible Consumption and Production',
            '13' => 'Climate Action',
            '14' => 'Life Below Water',
            '15' => 'Life on Land',
            '16' => 'Peace, Justice and Strong Institutions',
            '17' => 'Partnerships for the Goals',
        ];

        // Step 2: Fetch existing metrics
        $sdgMetrics = DB::table('imrad_metrics')
            ->join('imrads', 'imrad_metrics.imradID', '=', 'imrads.id')
            ->select(
                'imrads.SDG',
                DB::raw('SUM(imrad_metrics.downloads) as downloads'),
                DB::raw('SUM(imrad_metrics.saved) as saved'),
                DB::raw('SUM(imrad_metrics.views) as views'),
                DB::raw('AVG(imrad_metrics.rates) as avg_rating')
            )
            ->groupBy('imrads.SDG')
            ->get();

        // Step 3: Initialize response with all SDGs and zero metrics
        $sdgResponse = [];

        foreach ($SDG_list as $key => $sdgName) {
            $sdgResponse[$sdgName] = [
                'SDG' => $sdgName,
                'downloads' => 0,
                'saved' => 0,
                'views' => 0,
                'avg_rating' => '0.0000'
            ];
        }

        // Process each metric from the database
        foreach ($sdgMetrics as $metric) {
            // Split SDG string into individual SDGs
            $sdgs = array_map('trim', explode(',', $metric->SDG)); // Split and trim whitespace

            // Add metrics to each SDG found in the database
            foreach ($sdgs as $sdg) {
                if (isset($SDG_list[$sdg])) {
                    $sdgName = $SDG_list[$sdg];
                    $sdgResponse[$sdgName]['downloads'] += $metric->downloads;
                    $sdgResponse[$sdgName]['saved'] += $metric->saved;
                    $sdgResponse[$sdgName]['views'] += $metric->views;
                    $sdgResponse[$sdgName]['avg_rating'] = number_format($metric->avg_rating, 4, '.', '');
                }
            }
        }

        // Step 4: Return the response as JSON, preserving SDG order
        return response()->json(['sdgMetrics' => array_values($sdgResponse)]);
    }

    public function superreportsBarSDG() {
        $SDG_list = [
            '1' => 'No Poverty',
            '2' => 'Zero Hunger',
            '3' => 'Good Health and Well-being',
            '4' => 'Quality Education',
            '5' => 'Gender Equality',
            '6' => 'Clean Water and Sanitation',
            '7' => 'Affordable and Clean Energy',
            '8' => 'Decent Work and Economic Growth',
            '9' => 'Industry, Innovation and Infrastructure',
            '10' => 'Reduced Inequality',
            '11' => 'Sustainable Cities and Communities',
            '12' => 'Responsible Consumption and Production',
            '13' => 'Climate Action',
            '14' => 'Life Below Water',
            '15' => 'Life on Land',
            '16' => 'Peace, Justice and Strong Institutions',
            '17' => 'Partnerships for the Goals',
        ];

        // Step 2: Fetch existing metrics
        $sdgMetrics = DB::table('imrad_metrics')
            ->join('imrads', 'imrad_metrics.imradID', '=', 'imrads.id')
            ->select(
                'imrads.SDG',
                DB::raw('SUM(imrad_metrics.downloads) as downloads'),
                DB::raw('SUM(imrad_metrics.saved) as saved'),
                DB::raw('SUM(imrad_metrics.views) as views'),
                DB::raw('AVG(imrad_metrics.rates) as avg_rating')
            )
            ->groupBy('imrads.SDG')
            ->get();

        // Step 3: Initialize response with all SDGs and zero metrics
        $sdgResponse = [];

        foreach ($SDG_list as $key => $sdgName) {
            $sdgResponse[$sdgName] = [
                'SDG' => $sdgName,
                'downloads' => 0,
                'saved' => 0,
                'views' => 0,
                'avg_rating' => '0.0000'
            ];
        }

        // Process each metric from the database
        foreach ($sdgMetrics as $metric) {
            // Split SDG string into individual SDGs
            $sdgs = array_map('trim', explode(',', $metric->SDG)); // Split and trim whitespace

            // Add metrics to each SDG found in the database
            foreach ($sdgs as $sdg) {
                if (isset($SDG_list[$sdg])) {
                    $sdgName = $SDG_list[$sdg];
                    $sdgResponse[$sdgName]['downloads'] += $metric->downloads;
                    $sdgResponse[$sdgName]['saved'] += $metric->saved;
                    $sdgResponse[$sdgName]['views'] += $metric->views;
                    $sdgResponse[$sdgName]['avg_rating'] = number_format($metric->avg_rating, 4, '.', '');
                }
            }
        }

        // Step 4: Return the response as JSON, preserving SDG order
        return response()->json(['sdgMetrics' => array_values($sdgResponse)]);
    }

    public function viewReports() {
        return view('admin.admin_page.reports.reports');
    }

    public function reportsLineSDG() {

        $SDG_list = [
            '1' => 'No Poverty',
            '2' => 'Zero Hunger',
            '3' => 'Good Health and Well-being',
            '4' => 'Quality Education',
            '5' => 'Gender Equality',
            '6' => 'Clean Water and Sanitation',
            '7' => 'Affordable and Clean Energy',
            '8' => 'Decent Work and Economic Growth',
            '9' => 'Industry, Innovation and Infrastructure',
            '10' => 'Reduced Inequality',
            '11' => 'Sustainable Cities and Communities',
            '12' => 'Responsible Consumption and Production',
            '13' => 'Climate Action',
            '14' => 'Life Below Water',
            '15' => 'Life on Land',
            '16' => 'Peace, Justice and Strong Institutions',
            '17' => 'Partnerships for the Goals',
        ];

        $sdgMetrics = Imrad::select('SDG')
            ->get();

        $sdgResponse = [];

        // Create an associative array to count occurrences
        $sdgCountMap = [];

        // Loop through the fetched metrics
        foreach ($sdgMetrics as $metric) {
            // Split SDG string into individual SDGs
            $sdgs = array_map('trim', explode(',', $metric->SDG));

            // Count each SDG
            foreach ($sdgs as $sdg) {
                if (array_key_exists($sdg, $sdgCountMap)) {
                    $sdgCountMap[$sdg]++;
                } else {
                    $sdgCountMap[$sdg] = 1;
                }
            }
        }

        // Prepare the response with the counts
        $sdgResponse = [];
        foreach ($SDG_list as $key => $sdgName) {
            // Get the count from the map, default to 0 if not found
            $count = isset($sdgCountMap[$key]) ? $sdgCountMap[$key] : 0;

            // Store the SDG name and its count in the metrics array
            $sdgResponse[] = [
                'sdg' => $sdgName,
                'count' => $count
            ];
        }

        return response()->json(['sdgMetrics' => $sdgResponse]);
    }

    public function superreportsLineSDG() {

        $SDG_list = [
            '1' => 'No Poverty',
            '2' => 'Zero Hunger',
            '3' => 'Good Health and Well-being',
            '4' => 'Quality Education',
            '5' => 'Gender Equality',
            '6' => 'Clean Water and Sanitation',
            '7' => 'Affordable and Clean Energy',
            '8' => 'Decent Work and Economic Growth',
            '9' => 'Industry, Innovation and Infrastructure',
            '10' => 'Reduced Inequality',
            '11' => 'Sustainable Cities and Communities',
            '12' => 'Responsible Consumption and Production',
            '13' => 'Climate Action',
            '14' => 'Life Below Water',
            '15' => 'Life on Land',
            '16' => 'Peace, Justice and Strong Institutions',
            '17' => 'Partnerships for the Goals',
        ];

        $sdgMetrics = Imrad::select('SDG')
            ->get();

        $sdgResponse = [];

        // Create an associative array to count occurrences
        $sdgCountMap = [];

        // Loop through the fetched metrics
        foreach ($sdgMetrics as $metric) {
            // Split SDG string into individual SDGs
            $sdgs = array_map('trim', explode(',', $metric->SDG));

            // Count each SDG
            foreach ($sdgs as $sdg) {
                if (array_key_exists($sdg, $sdgCountMap)) {
                    $sdgCountMap[$sdg]++;
                } else {
                    $sdgCountMap[$sdg] = 1;
                }
            }
        }

        // Prepare the response with the counts
        $sdgResponse = [];
        foreach ($SDG_list as $key => $sdgName) {
            // Get the count from the map, default to 0 if not found
            $count = isset($sdgCountMap[$key]) ? $sdgCountMap[$key] : 0;

            // Store the SDG name and its count in the metrics array
            $sdgResponse[] = [
                'sdg' => $sdgName,
                'count' => $count
            ];
        }

        return response()->json(['sdgMetrics' => $sdgResponse]);
    }

    public function viewLineSDG() {
        return view('admin.admin_page.reports.reports-sdg-linegraph');
    }

    public function getDataUserStatistics() {
        // Active users per day count
        $activeUsersCount = LogHistory::selectRaw('DATE(created_at) as date, COUNT(DISTINCT user_code) as active_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // New users per day count
        $newUsersCount = GuestAccount::selectRaw('DATE(created_at) as date, COUNT(*) as new_user_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        // Preparing data for Chart.js
        $dates = $activeUsersCount->pluck('date')->map(function($date) {
            return date('M d', strtotime($date));
        })->toArray();

        $activeData = $activeUsersCount->pluck('active_count')->toArray();
        $newUserData = $newUsersCount->pluck('new_user_count')->toArray();

        return response()->json([
            'dates' => $dates,
            'active_users' => $activeData,
            'new_users' => $newUserData,
        ]);
    }

    public function supergetDataUserStatistics() {
        // Active users per day count
        $activeUsersCount = LogHistory::selectRaw('DATE(created_at) as date, COUNT(DISTINCT user_code) as active_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // New users per day count
        $newUsersCount = GuestAccount::selectRaw('DATE(created_at) as date, COUNT(*) as new_user_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Preparing data for Chart.js
        $dates = $activeUsersCount->pluck('date')->map(function($date) {
            return date('M d', strtotime($date));
        })->toArray();

        $activeData = $activeUsersCount->pluck('active_count')->toArray();
        $newUserData = $newUsersCount->pluck('new_user_count')->toArray();

        return response()->json([
            'dates' => $dates,
            'active_users' => $activeData,
            'new_users' => $newUserData,
        ]);
    }
    public function viewDataUserStatistics() {
        return view('admin.admin_page.reports.user_statistics');
    }

    public function getUserDemographics(Request $request)
{
    $filter = $request->input('filter');

    switch ($filter) {
        case 'gender':
            $guestGenderCount = GuestAccount::selectRaw('gender, COUNT(*) as count')
                ->whereIn('gender', ['male', 'female', 'other'])
                ->groupBy('gender')
                ->get();

            $adminGenderCount = Admin::selectRaw('gender, COUNT(*) as count')
                ->whereIn('gender', ['male', 'female', 'other'])
                ->groupBy('gender')
                ->get();

            $genderResult = [
                'male' => 0,
                'female' => 0,
                'other' => 0,
            ];

            // Accumulate counts from both collections
            foreach ([$guestGenderCount, $adminGenderCount] as $genderCounts) {
                foreach ($genderCounts as $gender) {
                    $genderResult[$gender->gender] += $gender->count;
                }
            }

            return response()->json(['gender' => $genderResult, 'age' => null, 'user' => null]);

        case 'ageRange':
            $adminAges = Admin::pluck('age');
            $guestAges = GuestAccount::pluck('age');

            $combinedAges = $adminAges->merge($guestAges);

            $ageResult = [
                'null' => 0,
                '13 - 19' => 0,
                '20 - 34' => 0,
                '35 - 49' => 0,
                '50+' => 0,
            ];

            foreach ($combinedAges as $age) {
                $ageValue = (int)$age;
                if ($ageValue < 13) {
                    $ageResult['null']++;
                } elseif ($ageValue <= 19) {
                    $ageResult['13 - 19']++;
                } elseif ($ageValue <= 34) {
                    $ageResult['20 - 34']++;
                } elseif ($ageValue <= 49) {
                    $ageResult['35 - 49']++;
                } else {
                    $ageResult['50+']++;
                }
            }

            return response()->json(['age' => $ageResult, 'gender' => null, 'user' => null]);

        case 'userRole':
            $userCounts = [
                'admin' => Admin::count(),
                'user' => GuestAccount::count(),
            ];

            return response()->json(['user' => $userCounts, 'gender' => null, 'age' => null]);

        default:
            return response()->json([], 400);
    }
}



public function supergetUserDemographics(Request $request)
{
    $filter = $request->input('filter');

    switch ($filter) {
        case 'gender':
            $guestGenderCount = GuestAccount::selectRaw('gender, COUNT(*) as count')
                ->whereIn('gender', ['male', 'female', 'other'])
                ->groupBy('gender')
                ->get();

            $adminGenderCount = Admin::selectRaw('gender, COUNT(*) as count')
                ->whereIn('gender', ['male', 'female', 'other'])
                ->groupBy('gender')
                ->get();

            $genderResult = [
                'male' => 0,
                'female' => 0,
                'other' => 0,
            ];

            // Accumulate counts from both collections
            foreach ([$guestGenderCount, $adminGenderCount] as $genderCounts) {
                foreach ($genderCounts as $gender) {
                    $genderResult[$gender->gender] += $gender->count;
                }
            }

            return response()->json(['gender' => $genderResult, 'age' => null, 'user' => null]);

        case 'ageRange':
            $adminAges = Admin::pluck('age');
            $guestAges = GuestAccount::pluck('age');

            $combinedAges = $adminAges->merge($guestAges);

            $ageResult = [
                'null' => 0,
                '13 - 19' => 0,
                '20 - 34' => 0,
                '35 - 49' => 0,
                '50+' => 0,
            ];

            foreach ($combinedAges as $age) {
                $ageValue = (int)$age;
                if ($ageValue < 13) {
                    $ageResult['null']++;
                } elseif ($ageValue <= 19) {
                    $ageResult['13 - 19']++;
                } elseif ($ageValue <= 34) {
                    $ageResult['20 - 34']++;
                } elseif ($ageValue <= 49) {
                    $ageResult['35 - 49']++;
                } else {
                    $ageResult['50+']++;
                }
            }

            return response()->json(['age' => $ageResult, 'gender' => null, 'user' => null]);

        case 'userRole':
            $userCounts = [
                'admin' => Admin::count(),
                'user' => GuestAccount::count(),
            ];

            return response()->json(['user' => $userCounts, 'gender' => null, 'age' => null]);

        default:
            return response()->json([], 400);
    }
}

    public function viewUserDemographics()
    {
        return view('admin.admin_page.reports.user_demographics');
    }

    public function viewfileupload()
    {
        return view('admin.admin_page.reports.report_fileupload');
    }

    public function reportfilecount(Request $request) {
        $uploads = DB::table('imrads')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as upload_count'))
            ->groupBy('month')
            ->get();

        $monthlyCounts = array_fill(0, 12, 0);

        foreach ($uploads as $upload) {
            $monthlyCounts[$upload->month - 1] = $upload->upload_count;
        }

        return response()->json(['uploads' => $monthlyCounts]);
    }

    public function superreportfilecount(Request $request) {
        $uploads = DB::table('imrads')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as upload_count'))
            ->groupBy('month')
            ->get();

        $monthlyCounts = array_fill(0, 12, 0);

        foreach ($uploads as $upload) {
            $monthlyCounts[$upload->month - 1] = $upload->upload_count;
        }

        return response()->json(['uploads' => $monthlyCounts]);
    }


}
