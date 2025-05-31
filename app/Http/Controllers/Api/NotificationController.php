<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
     public function getUserNotifications()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }

        $notifications = $user->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => class_basename($notification->type),
                'data' => $notification->data,
                'read_at' => $notification->read_at 
                    ? Carbon::parse($notification->read_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') 
                    : null,
                'created_at' => Carbon::parse($notification->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Notifications retrieved successfully',
            'data' => $notifications,
        ], 200);
    }       
    

public function deleteAllUserNotifications()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated'
        ], 401);
    }

    DB::table('notifications')
        ->where('notifiable_id', $user->id)
        ->where('notifiable_type', get_class($user))
        ->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Semua notifikasi berhasil dihapus',
        'data' => $user,
    ], 200);
}
}