<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VillageController extends Controller
{
    public function signin(Request $input)
    {
        $user = User::where('username', $input->username)->first();
        return response()->json([
            'message' => 'Berhasil Login',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('bareerToken')->plainTextToken,
            ]
        ], Response::HTTP_ACCEPTED);
    }
    public function index()
    {
        try {
            $response = [
                "message" => "Data Village",
                "data" => Village::with('district')->get()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'village' => ["required", "string"],
            'district_id' => ["required", "numeric"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = Village::create([
                "village" => $input->village,
                "district_id" => $input->district_id
            ]);
            $response = [
                "message" => "Data Berhasil Ditambahkan",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $village = Village::where('id', $id)->with('district')->get();
            if (count($village) == 0) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                "message" => "Data Village",
                "data" => $village
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'village' => ["required", "string"],
            'district_id' => ["required", "numeric"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $village = Village::find($id);
            if (!$village) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $village->village = $input->village;
            $village->district_id = $input->district_id;
            $village->save();
            return response()->json([
                "message" => "Data Telah Diubah!",
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" =>  $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        try {
            $village = Village::find($id);
            if (!$village) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $village->delete();
            return response()->json([
                "message" => "Data Telah Dihapus!"
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
