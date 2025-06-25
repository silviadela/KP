<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ThingSpeakController extends Controller
{
    public function readData()
    {
        $channelId = env('THINGSPEAK_CHANNEL_ID');
        $readApiKey = env('THINGSPEAK_READ_KEY');

        $response = Http::get("https://api.thingspeak.com/channels/$channelId/feeds.json", [
            'api_key' => $readApiKey,
            'results' => 500
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $feeds = collect($data['feeds'])->map(function ($item) {
                $utc = Carbon::parse($item['created_at']);
                $wib = $utc->setTimezone('Asia/Jakarta');
                $item['created_at'] = $wib->format('d-m-Y H:i:s');
                return $item;
            });

            return view('thingspeak.data', [
                'feeds' => $feeds
            ]);
        }

        return "Gagal mengambil data dari ThingSpeak.";
    }

    public function getJsonData()
    {
        $channelId = env('THINGSPEAK_CHANNEL_ID');
        $readApiKey = env('THINGSPEAK_READ_KEY');

        $response = Http::get("https://api.thingspeak.com/channels/$channelId/feeds.json", [
            'api_key' => $readApiKey,
            'results' => 500
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $feeds = collect($data['feeds'])->map(function ($item) {
                $utc = Carbon::parse($item['created_at']);
                $wib = $utc->setTimezone('Asia/Jakarta');
                $item['created_at'] = $wib->format('d-m-Y H:i:s');
                return $item;
            });

            return response()->json($feeds);
        }

        return response()->json([], 500);
    }
}
