<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $quote = new Quote();
        $quote->movie_id = $request->movie_id;
        $quote->thumbnail = request()->file('thumbnail')->store('thumbnails');
        $quote->setTranslation('quote', 'en', $request->quote_en);
        $quote->setTranslation('quote', 'ka', $request->quote_ka);
        $quote->save();

        return response()->json('Quote created Successfully');
    }

    public function show($id): JsonResponse
    {
        $quotes = Quote::where('movie_id', '=', $id)->get();

        return response()->json($quotes);
    }

    public function showQuote($quoteId): JsonResponse
    {
        $quote = Quote::where('id', '=', $quoteId)->get();

        return response()->json($quote);
    }
}
