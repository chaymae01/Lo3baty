<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function latest(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();
        $type = $request->query('type'); 

        $notifications = $user->notifications()
            ->when($type === 'annonce', function($query) {
                return $query->whereIn('data->type', ['nouvelle_annonce', 'annonce_modifiee']);
            })
            ->when($type === 'other', function($query) {
                return $query->whereNotIn('data->type', ['nouvelle_annonce', 'annonce_modifiee']);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $notifications->map(function($notification) {
            return [
                'id' => $notification->id,
                'type' => $notification->data['type'] ?? null,
                'message' => $notification->data['message'] ?? '',
                'sujet' => $notification->data['sujet'] ?? '',
                'url' => $notification->data['url'] ?? '#',
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
                'data' => $notification->data
            ];
        });
    }

    public function markAsRead(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();
        $type = $request->query('type'); // 'annonce' ou 'other'

        $query = $user->unreadNotifications();
        
        if ($type) {
            $query = $query->whereIn('data->type', 
                $type === 'annonce' 
                    ? ['nouvelle_annonce', 'annonce_modifiee'] 
                    : ['reclamation_reponse', 'reservation_expiration']);
        }

        $query->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function unreadCount(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();
        $type = $request->query('type'); 

        $count = $user->unreadNotifications()
            ->when($type === 'annonce', function($query) {
                return $query->whereIn('data->type', ['nouvelle_annonce', 'annonce_modifiee']);
            })
            ->when($type === 'other', function($query) {
                return $query->whereNotIn('data->type', ['nouvelle_annonce', 'annonce_modifiee']);
            })
            ->count();

        return response()->json(['count' => $count]);
    }
public function savePreferences(Request $request)
{
    $validated = $request->validate([
        'annonce_disabled' => 'required|boolean'
    ]);
    
    /** @var \App\Models\Utilisateur $user */
    $user = Auth::user();
    $user->notification_annonce = $validated['annonce_disabled'] ? 'desactive' : 'active';
    $user->save();

    return response()->json(['success' => true]);
}

public function getPreferences()
{
    return response()->json([
        'annonce_disabled' => Auth::user()->notification_annonce === 'desactive'
    ]);
}
}