<!-- resources/views/survey.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-2xl">
        <h2 class="text-3xl font-semibold text-center mb-6">Create Your Survey</h2>
        <form action="{{ route('survey.store') }}" method="POST">
            @csrf
            
            <!-- Survey Name Input -->
            <div class="mb-6">
                <label for="survey_name" class="block text-lg font-medium text-gray-700">Survey Name</label>
                <input type="text" name="survey_name" required class="mt-1 border border-gray-300 rounded-lg p-2 w-full" placeholder="Enter survey name">
            </div>

            <div id="question-container" class="space-y-6">
                <div class="question flex flex-col">
                    <label class="block text-lg font-medium text-gray-700">Question 1</label>
                    <input type="text" name="questions[]" required class="mt-1 border border-gray-300 rounded-lg p-2" placeholder="Enter your question">
                    <select name="question_type[]" class="mt-2 border border-gray-300 rounded-lg p-2" onchange="toggleOptions(this)">
                        <option value="text">Text</option>
                        <option value="rating">Rating</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkboxes</option>
                    </select>
                    <div class="options mt-2" style="display: none;">
                        <label class="font-medium text-gray-700">Options (comma-separated)</label>
                        <input type="text" name="options[]" class="mt-1 border border-gray-300 rounded-lg p-2" placeholder="Enter options (e.g., Option 1, Option 2)">
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="addQuestion()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Another Question</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Submit Survey</button>
            </div>
        </form>
    </div>

    <script>
        function addQuestion() {
            const container = document.getElementById('question-container');
            const questionCount = container.children.length + 1; // Count existing questions
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question', 'flex', 'flex-col', 'space-y-2');
            newQuestion.innerHTML = `
                <label class="block text-lg font-medium text-gray-700">Question ${questionCount}</label>
                <input type="text" name="questions[]" required class="mt-1 border border-gray-300 rounded-lg p-2" placeholder="Enter your question">
                <select name="question_type[]" class="mt-2 border border-gray-300 rounded-lg p-2" onchange="toggleOptions(this)">
                    <option value="text">Text</option>
                    <option value="rating">Rating</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkbox">Checkboxes</option>
                </select>
                <div class="options mt-2" style="display: none;">
                    <label class="font-medium text-gray-700">Options (comma-separated)</label>
                    <input type="text" name="options[]" class="mt-1 border border-gray-300 rounded-lg p-2" placeholder="Enter options (e.g., Option 1, Option 2)">
                </div>
            `;
            container.appendChild(newQuestion);
        }

        function toggleOptions(selectElement) {
            const optionsDiv = selectElement.nextElementSibling;
            if (selectElement.value !== 'text') {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>
