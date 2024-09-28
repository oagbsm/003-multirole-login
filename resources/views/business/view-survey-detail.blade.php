<!-- resources/views/surveys/view-survey-detail.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Details - {{ $survey->survey_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <!-- Survey Header -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $survey->survey_name }}</h1>
        <p class="text-gray-600">Survey ID: {{ $survey->id }}</p>
    </div>

    <!-- Survey Questions Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Questions</h2>
        <ul class="list-disc pl-6 space-y-2">
            @foreach (json_decode($survey->questions) as $index => $question)
                <li>
                    <span class="text-lg font-medium text-gray-700">Q{{ $index + 1 }}:</span>
                    <span class="text-gray-800">{{ $question }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Question Types Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Question Types</h2>
        <ul class="list-disc pl-6 space-y-2">
            @foreach (json_decode($survey->question_type) as $index => $type)
                <li>
                    <span class="text-lg font-medium text-gray-700">Type {{ $index + 1 }}:</span>
                    <span class="text-gray-800">{{ ucfirst($type) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Options Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Options</h2>
        <ul class="list-disc pl-6 space-y-2">
            @foreach (json_decode($survey->options) as $index => $option)
                <li>
                    <span class="text-lg font-medium text-gray-700">Option {{ $index + 1 }}:</span>
                    <span class="text-gray-800">{{ $option }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Back Button -->
    <div class="flex justify-start">
        <a href="/business/viewsurvey" class="inline-block bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700">Back to Surveys</a>
    </div>
</div>

</body>
</html>
