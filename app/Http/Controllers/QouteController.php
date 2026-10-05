<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class QouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quoteData = $this->fetchRandomQuote();

        return view('welcome', ['singleQoute' => $quoteData]);
    }

    /**
     * Get a random quote via JSON endpoint for dynamic updates.
     */
    public function getRandomQuote()
    {
        return response()->json($this->fetchRandomQuote());
    }

    /**
     * Helper to fetch a random quote from API with reliable fallback.
     */
    private function fetchRandomQuote()
    {
        try {
            $response = Http::timeout(5)->get('https://dummyjson.com/quotes');
            if ($response->successful()) {
                $quotes = $response->json()['quotes'] ?? [];
                if (! empty($quotes)) {
                    return $quotes[array_rand($quotes)];
                }
            }
        } catch (\Throwable $e) {
            // Silently handle connection issues with standard fallback quotes
        }

        $fallbackQuotes = [
            ['id' => 1, 'quote' => 'When I am silent, I have thunder hidden inside.', 'author' => 'Rumi'],
            ['id' => 2, 'quote' => "Your time is limited, so don't waste it living someone else's life.", 'author' => 'Steve Jobs'],
            ['id' => 3, 'quote' => 'The only way to do great work is to love what you do.', 'author' => 'Steve Jobs'],
            ['id' => 4, 'quote' => 'Be the change that you wish to see in the world.', 'author' => 'Mahatma Gandhi'],
            ['id' => 5, 'quote' => 'In the middle of difficulty lies opportunity.', 'author' => 'Albert Einstein'],
        ];

        return $fallbackQuotes[array_rand($fallbackQuotes)];
    }
}
