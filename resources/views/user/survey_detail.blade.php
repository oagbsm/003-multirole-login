<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->survey_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $survey->survey_name }}</h1>
        <form action="{{ route('survey.submit', $survey->id) }}" method="POST">
            @csrf

            <!-- Hidden input for the survey ID -->
            <input type="hidden" name="survey_id" value="{{ $survey->id }}">

            @foreach ($questions as $index => $question)
                <div class="mb-4">
                    <label class="block text-lg">{{ $question }}</label>
                    
                    {{-- Display the cleaned options --}}
                    @foreach ($cleanedOptions as $option)
                        <div>
                            <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}" id="option-{{ $index }}-{{ $loop->index }}">
                            <label for="option-{{ $index }}-{{ $loop->index }}">{{ $option }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit Answers</button>
        </form>
    </div>
</body>
</html>
