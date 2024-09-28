<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Survey Responses</h1>

            @if (empty($matchingResponses))
                <p class="text-gray-600">No responses available for this survey.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($matchingResponses as $response)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h2 class="text-xl font-semibold mb-2">Response ID: {{ $response['id'] }}</h2>
                            <p class="text-gray-700 mb-4">{{ $response['formatted_answers'] }}</p>
                            <p class="text-gray-500">Submitted on: {{ \Carbon\Carbon::parse($response['created_at'])->format('M d, Y h:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif


        </div>
    </div>
</x-app-layout>
