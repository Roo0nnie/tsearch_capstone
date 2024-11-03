<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImradMetric;
use App\Models\Imrad;


class ImradMetricController extends Controller
{

    public function showMetrics($imradID)
    {
        $metrics = ImradMetric::where('imradID', $imradID)->get();

        return view('imrad.show', compact('metrics'));
    }

        public function updateClicks($imradID, $userCode)
    {
        $metric = ImradMetric::firstOrCreate(
            ['imradID' => $imradID, 'user_code' => $userCode],
            ['no_clicks' => 0, 'no_downloads' => 0]
        );

        $metric->increment('no_clicks');
        $metric->save();


        return response()->json(['message' => 'Click recorded successfully']);
    }

    public function updateDownloads(Request $request, $imradID)
    {
        $metric = ImradMetric::where('imradID', $imradID)->first();

        if ($metric) {

            $metric->increment('downloads');
            $metric->save();

            return response()->json(['message' => 'Download recorded successfully']);
        }

        return response()->json(['message' => 'Metric not found'], 404);
    }

    public function updateViews(Request $request, $imradID)
    {
        $metric = ImradMetric::where('imradID', $imradID)->first();

        if ($metric) {

            $metric->increment('views');
            $metric->save();

            return response()->json(['message' => 'Download recorded successfully']);
        }

        return response()->json(['message' => 'Metric not found'], 404);
    }

    public function updateRating(Request $request, $imradID, $userCode)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $metric = ImradMetric::firstOrCreate(
            ['imradID' => $imradID, 'user_code' => $userCode],
            ['no_clicks' => 0, 'no_downloads' => 0]
        );

        $metric->rating = $request->rating;
        $metric->save();

        return response()->json(['message' => 'Rating recorded successfully']);
    }


}
