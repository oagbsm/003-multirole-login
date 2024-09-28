<?php

namespace App\Http\Controllers;
use App\Models\Survey; 
use App\Models\Response; // Import the Survey model
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{




    

public function show($id)
{
    // Retrieve the survey by ID or fail if not found
    $survey = Survey::findOrFail($id); 
    
    // Assuming you store questions and options as JSON
    $questions = json_decode($survey->questions); // Decode questions from JSON
    $cleanedOptions = explode(',', $survey->options); // Split the options into an array

    // Pass the survey data to the view
    return view('user.survey_detail', [
        'survey' => $survey,
        'questions' => $questions, // Pass questions to the view
        'cleanedOptions' => $cleanedOptions, // Pass all options to the view
    ]);
}
public function submitAnswers(Request $request)
{
    $userId = $request->user()->id; // This will show the user ID and stop execution

    // Get the survey ID from the request
    $surveyId = $request->input('survey_id');

    // Get the answers array from the request
    $answers = $request->input('answers'); // This should be an array where the key is question index

    // Prepare an array to store the questions and answers
    $formattedAnswers = [];

    foreach ($answers as $index => $answer) {
        // Get the corresponding question text (this assumes you have access to the questions)
        $questionText = ""; // Replace this with your logic to get the question text based on the index

        // If the answer is an array (e.g., checkbox answers), convert it to a string
        if (is_array($answer)) {
            $answer = implode(',', $answer); // Join checkbox answers with commas
        }

        // Store the question index, question text, and answer in the formatted answers array
        $formattedAnswers[] = [
            'question_index' => $index,
            'answer' => $answer,
        ];
    }

    // Convert the formatted answers array to JSON
    $formattedAnswersJson = json_encode($formattedAnswers);

    // Save the formatted answers to the survey_responses table
    $response = new Response();
    $response->survey_id = $surveyId;
    $response->user_id = $userId;

    $response->formatted_answers = $formattedAnswersJson; // Store JSON
    $response->save();

    // For debugging, you can use dd to see the formatted answers
    // dd([
    //     'survey_id' => $surveyId,
    //     'formatted_answers' => $formattedAnswersJson
    // ]);

    // Redirect or return a response
    Session::flash('alert', 'Your action was successful!Please wait 1 hr whilst your credits are being verified');

    return redirect()->route('dashboard'); // Assuming 'dashboard' is the name of the route for '/user'

}


public function viewsurveydetail($id)
{
    $survey = Survey::findOrFail($id);
    return view('business.view-survey-detail', compact('survey'));
}

public function userviewsurvey(){
    $userId = auth()->id(); // or any other method to retrieve user ID

    // Retrieve all surveys (modify this according to your survey model)
    $surveys = DB::table('surveys')->get(); // Assuming you have a 'surveys' table

    // Count the number of completed responses for the user
    $completedCount = DB::table('responses')
        ->where('user_id', $userId)
        ->count();



    $surveys = Survey::all();
    $completedSurveyIds = Response::where('user_id', $userId)
    ->pluck('survey_id')
    ->toArray();
        // dd($completedSurveyIds);
        $completedSurveyIds = Response::where('user_id', $userId)
        ->pluck('survey_id')
        ->toArray();

    // Fetch surveys that the user has not completed
    $surveys = Survey::whereNotIn('id', $completedSurveyIds)->get();

    // Pass the surveys to the 'surveys.index' view
        return view('user.dashboard', [
            'surveys' => $surveys,
            'completedCount' => $completedCount,
        ]);    // Pass the surveys to the 'surveys.index' view
    // dd($surveys);

}

public function analytics()

{

    $userId= (Auth::id());
    $surveys = Survey::where('user_id', $userId)->get();
    $uniqueSurveyIds = $surveys->unique('id')->pluck('id')->toArray();
    $responses = Response::whereIn('survey_id', $uniqueSurveyIds)->get();
    $matchingResponses = $responses->toArray();


    // dd($matchingResponses);

// return view('business.view-analytics', compact('surveys'));
return view('business.view-analytics', compact( 'matchingResponses'));


}



public function destroy($id)
{
    // Retrieve the survey by its ID
    $survey = Survey::findOrFail($id);

    // Delete the survey
    $survey->delete();

    // Redirect back to the surveys list with a success message
    return redirect()->back()->with('success', 'Survey deleted successfully.');
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
