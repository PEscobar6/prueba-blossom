<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Episodes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EpisodesController extends Controller
{
    public function index()
    {
        $episodes = Episodes::all();

        if ($episodes->isEmpty()) {
            return response()->json([
                'message' => 'No episodes found',
                'status' => 404
            ], 200);
        }

        $data = [
            'message' => 'Episodes found',
            'data' => $episodes,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'air_date' => 'required|date',
                'episode' => 'required|string',
                'url' => 'required|string',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                    'status' => 422
                ];
                return response()->json($data, 422);
            }

            Episodes::create([
                'name' => $request->name,
                'air_date' => strtotime($request->air_date),
                'episode' => $request->episode,
                'url' => $request->url,
            ]);

            $data = [
                'message' => 'Episode created successfully',
                'status' => 201
            ];

            return response()->json($data, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the episode',
                'status' => 500
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $episode = Episodes::with('characters')->findOrFail($id);
            $data = [
                'message' => 'Episode found',
                'data' => $episode,
                'status' => 200
            ];
            return response()->json($data, 200);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                'message' => 'Episode not found',
                'status' => 404
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the episode',
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $episode = Episodes::find($id);

            if (!$episode) {
                return response()->json([
                    'message' => 'Episode not found',
                    'status' => 404
                ], 200);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'air_date' => 'required|date',
                'episode' => 'required|string',
                'url' => 'required|string',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                    'status' => 422
                ];
                return response()->json($data, 422);
            }

            $episode->update([
                'name' => $request->name,
                'air_date' => strtotime($request->air_date),
                'episode' => $request->episode,
                'url' => $request->url,
            ]);

            $data = [
                'message' => 'Episode updated successfully',
                'data' => $episode,
                'status' => 200
            ];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the episode',
                'status' => 500
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $episode = Episodes::find($id);

            if (!$episode) {
                return response()->json([
                    'message' => 'Episode not found',
                    'status' => 404
                ], 200);
            }

            $episode->delete();

            $data = [
                'message' => 'Episode deleted successfully',
                'status' => 200
            ];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the episode',
                'status' => 500
            ], 500);
        }
    }

    public function updatePartial(Request $request, $id)
    {
        try {
            $episode = Episodes::find($id);

            if (!$episode) {
                return response()->json([
                    'message' => 'Episode not found',
                    'status' => 404
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string',
                'air_date' => 'sometimes|required|date',
                'episode' => 'sometimes|required|string',
                'url' => 'sometimes|required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                    'status' => 422
                ], 422);
            }

            $data = $request->only(['name', 'air_date', 'episode', 'url']);
            if (isset($data['air_date'])) {
                $data['air_date'] = strtotime($data['air_date']);
            }

            $episode->update($data);

            return response()->json([
                'message' => 'Episode updated successfully',
                'data' => $episode,
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the episode',
                'status' => 500
            ], 500);
        }
    }
}
