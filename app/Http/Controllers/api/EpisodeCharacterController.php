<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Episodes;
use Illuminate\Http\Request;

class EpisodeCharacterController extends Controller
{
    public function assignCharactersToEpisode(Request $request, $episodeId)
    {
        $request->validate([
            'character_ids' => 'required|array',
            'character_ids.*' => 'exists:characters,id',
        ]);

        $episode = Episodes::findOrFail($episodeId);
        $episode->characters()->sync($request->character_ids);

        return jsonResponse(data: [
            'episode' => $episode->load('characters'),
        ], message: 'Characters assigned to episode successfully', status: 200);
    }
}
