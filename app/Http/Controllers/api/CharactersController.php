<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Characters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CharactersController extends Controller
{
    public function index()
    {
        $characters = Characters::all();

        if ($characters->isEmpty()) {
            return response()->json([
                'message' => 'No characters found',
                'status' => 404
            ], 200);
        }

        return response()->json([
            'message' => 'Characters found',
            'data' => $characters,
            'status' => 200
        ], 200);
    }

    public function show($id)
    {
        try {
            $character = Characters::findOrFail($id);

            return response()->json([
                'message' => 'Character found',
                'data' => $character,
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Character not found',
                'status' => 404
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|string',
            'species' => 'required|string',
            'type' => 'nullable|string',
            'gender' => 'required|string',
            'origin' => 'required|array',
            'location' => 'required|array',
            'image' => 'required|string',
            'url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        try {
            Characters::create([
                'name' => $request->name,
                'status' => $request->status,
                'species' => $request->species,
                'type' => $request->type,
                'gender' => $request->gender,
                'origin' => $request->origin,
                'location' => $request->location,
                'image' => $request->image,
                'url' => $request->url
            ]);

            return response()->json([
                'message' => 'Character created successfully',
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the character',
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $character = Characters::find($id);

        if (!$character) {
            return response()->json([
                'message' => 'Character not found',
                'status' => 404
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|string',
            'species' => 'required|string',
            'type' => 'nullable|string',
            'gender' => 'required|string',
            'origin' => 'required|array',
            'location' => 'required|array',
            'image' => 'required|string',
            'url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        try {
            $character->update([
                'name' => $request->name,
                'status' => $request->status,
                'species' => $request->species,
                'type' => $request->type,
                'gender' => $request->gender,
                'origin' => $request->origin,
                'location' => $request->location,
                'image' => $request->image,
                'url' => $request->url
            ]);

            return response()->json([
                'message' => 'Character updated successfully',
                'data' => $character,
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the character',
                'status' => 500
            ], 500);
        }
    }

    public function destroy($id)
    {
        $character = Characters::find($id);

        if (!$character) {
            return response()->json([
                'message' => 'Character not found',
                'status' => 404
            ], 200);
        }

        try {
            $character->delete();

            return response()->json([
                'message' => 'Character deleted successfully',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the character',
                'status' => 500
            ], 500);
        }
    }

    public function updatePartial(Request $request, $id)
    {
        $character = Characters::find($id);

        if (!$character) {
            return response()->json([
                'message' => 'Character not found',
                'status' => 404
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'status' => 'sometimes|string',
            'species' => 'sometimes|string',
            'type' => 'nullable|string',
            'gender' => 'sometimes|string',
            'origin' => 'sometimes|json',
            'location' => 'sometimes|json',
            'image' => 'sometimes|string',
            'url' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        try {
            $data = $request->only([
                'name',
                'status',
                'species',
                'type',
                'gender',
                'origin',
                'location',
                'image',
                'url'
            ]);
            $character->update($data);
            return response()->json([
                'message' => 'Character updated successfully',
                'data' => $character,
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the character',
                'status' => 500
            ], 500);
        }
    }
}
