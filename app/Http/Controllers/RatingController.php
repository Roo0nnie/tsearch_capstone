<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\ImradMetric;

class RatingController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'imrad_id' => 'required|exists:imrad_metrics,imradID',
            'rating' => 'required|integer|between:1,5',
        ]);

        $imrad_id = $request->input('imrad_id');
        $user_code = Auth::user()->user_code;

        $metric = ImradMetric::where('imradID', $imrad_id)->first();

        if (!$metric) {
            return response()->json([
                'success' => false,
                'message' => 'Metric ID not found for this imrad.',
            ]);
        }

        $metric_id = $metric->id;

        $existingRating = Rating::where('metric_id', $metric_id)
            ->where('user_code', $user_code)
            ->first();

        try {
            if ($existingRating) {
                $existingRating->update(['rating' => $request->input('rating')]);
            } else {
                Rating::create([
                    'metric_id' => $metric_id,
                    'user_code' => $user_code,
                    'rating' => $request->input('rating'),
                ]);
            }

            $averageRating = Rating::where('metric_id', $metric_id)->avg('rating');
            $metric->update(['rates' => $averageRating]);

            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully.',
                'average_rating' => $averageRating,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
            ]);
        }
    }
}
