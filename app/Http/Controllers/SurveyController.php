<?php

namespace App\Http\Controllers;
use App\Models\Survey; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{

    public function show($id)
{
    // Retrieve the survey by its ID
    $survey = Survey::findOrFail($id);

    // Return the view with survey data
    return view('surveys.show', compact('survey'));
}

    public function create()
    {
                // Get the currently authenticated user
        return view('business.create-survey');
    }
    public function viewsurvey()
    {
                // Get the currently authenticated user
              $surveys = Survey::where('user_id', Auth::id())->get();

        // Return the view with survey data
        return view('business.view-survey', compact('surveys'));
    }
    
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'survey_name' => 'required|string|max:255', // Validate the survey name
            'questions.*' => 'required|string|max:255', // Validate each question
            'question_type.*' => 'required|string|in:text,rating,dropdown,checkbox', // Validate question types
            'options.*' => 'nullable|string', // Validate options, if provided
        ]);
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Use dd() to dump the user ID
        // dd($userId); // This will stop execution and display the user ID
        // Create a new survey entry in the database
        $survey = Survey::create([
            'survey_name' => $request->input('survey_name'),
            'questions' => json_encode($request->input('questions')),
            'question_type' => json_encode($request->input('question_type')),
            'options' => json_encode($request->input('options')),
                    'user_id' => $userId, // Ensure user_id is included here

        ]);

        // Display a success message or redirect as needed
        return redirect()->route('business')->with('success', 'Survey created successfully.');
    }
}
