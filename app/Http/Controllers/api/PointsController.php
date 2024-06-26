<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PointType;
use app\Models\User;
use App\Models\FlagType;
use App\Models\NotificationInfo;

use App\Models\UserDetail;
class PointsController extends Controller
{

    public function updateNofic(Request $request){
        // Validate request data
        $validatedData = $request->validate([
            'id'=>'required|exists:notification_infos,id',
            'title' => 'required',
            'body' => 'required',
        ]);

        // Find the notification by ID
        $notification = NotificationInfo::findOrFail($request->id);

        // Update notification details
        $notification->update([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
        ]);

        // Return success response
        return response()->json(['message' => 'Notification updated successfully', 'notification' => $notification]);
    }
    public function nofic(){
        return response()->json(['message' => 'Notifications are :', 'data' => NotificationInfo::all()], 200);

    }
    public function index(Request $request)
    {
        $data = $request->all();
        $validator = validator::make($data, [
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {
            PointType::create([
                'type' => $request->type,
            ]);
            return response()->json(['message' => 'Point Type set successfully', 'code' => 200], 200);
        }
    }



    public function load(){
        return response()->json(['message' => 'Points fetched successfully', 'code' => 200,'data'=>PointType::all()], 200);
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $validator = validator::make($data, [
            'type' => 'required|exists:point_types,type',
            'points' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {
                $point = PointType::where('type', $data['type'])->first();
                $point->update([
                    'type' => $request->type,
                    'points' => json_decode($request->points),
                ]);
                $point->save();
            return response()->json(['message' => 'Points set successfully', 'code' => 200, 'data' => $point], 200);
        }
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        $validator = validator::make($data, [
            'id' => 'required|exists:admin_point,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {
            PointType::where('id', $data['id'])->delete();
            return response()->json(['message' => 'Point deleted successfully', 'code' => 200], 200);
        }
    }


    public function progress(Request $request){
        $data = $request->all();
        $validator = validator::make($data, [
            'flag' => 'required|string|unique:flag_types,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {}
    }

    public function delete_flag(Request $request){
        $data = $request->all();
        $validator = validator::make($data, [
            'id' => 'required|exists:flag_types,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {
                Flagtype::where('id',$request->id)->forceDelete();
                return response()->json(['message' => 'Flag deleted successfully', 'code' => 200], 200);
        }
    }
    public function flag(Request $request){
        $data = $request->all();
        $validator = validator::make($data, [
            'flag' => 'required|string|unique:flag_types,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        } else {
                $flag=Flagtype::create(['name'=>$data['flag']]);
                return response()->json(['message' => 'Flag added successfully', 'code' => 200,'data'=>$flag], 200);
        }
    }
}
