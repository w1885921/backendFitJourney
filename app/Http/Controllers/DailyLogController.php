<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\DailyLog;
use Carbon\Carbon;
class DailyLogController extends Controller {

    public function updateCalories(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'calories_consumed' => 'required|integer|min:0',
        ]);

        // Get today's log for the user
        $log = DailyLog::firstOrCreate(
            ['user_id' => $user->id, 'log_date' => Carbon::today()],
            ['calories_consumed' => 0, 'steps_taken' => 0, 'calories_burned' => 0]
        );

        // Update calories
        $log->update([
            'calories_consumed' => $request->calories_consumed,
        ]);

        return response()->json(['message' => 'Calories updated successfully'], 200);
    }

    public function updateSteps(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'steps_taken' => 'required|integer|min:0',
        ]);

        // Get today's log for the user
        $log = DailyLog::firstOrCreate(
            ['user_id' => $user->id, 'log_date' => Carbon::today()],
            ['calories_consumed' => 0, 'steps_taken' => 0, 'calories_burned' => 0]
        );

        // Update steps & calories burned
        $log->update([
            'steps_taken' => $request->steps_taken,
            'calories_burned' => $request->steps_taken * 0.04, // Example formula
        ]);

        return response()->json(['message' => 'Steps updated successfully'], 200);
    }

}