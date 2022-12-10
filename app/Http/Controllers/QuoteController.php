<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $quote = new Quote();
        $quote->movie_id = $request->movie_id;
        $quote->user_id = $request->user_id;
        if ($request->hasFile('thumbnail')) {
            $quote->thumbnail = request()->file('thumbnail')->store('thumbnails');
        }
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
        $quote = Quote::with('comments.user', 'likes')->where('id', '=', $quoteId)->get();

        return response()->json($quote);
    }

    public function destroy(Quote $quote, $id): JsonResponse
    {
        $quote = Quote::find($id);
        $quote->delete();
        return response()->json('Quote removed Successfully');
    }

    public function update(Quote $quote, StoreQuoteRequest $request): JsonResponse
    {
        $quote = Quote::find($request->id);

        if ($request->hasFile('thumbnail')) {
            $quote->thumbnail = $request->file('thumbnail')->store('thumbnails');
        }

        $quote->movie_id = $request->movie_id;
        $quote->user_id = $request->user_id;
        $quote->setTranslation('quote', 'en', $request->quote_en);
        $quote->setTranslation('quote', 'ka', $request->quote_ka);
        $quote->update();

        return response()->json('Quote updated Successfully');
    }
}
