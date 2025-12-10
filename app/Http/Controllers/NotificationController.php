<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = $this->getAuthenticatedUser();
        
        if (!$user) {
            return redirect('/login');
        }

        $notifications = $user->notifications()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function unreadCount()
    {
        $user = $this->getAuthenticatedUser();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        return response()->json(['count' => $user->unreadNotifications->count()]);
    }

    public function markAsRead($id)
    {
        $user = $this->getAuthenticatedUser();
        
        if (!$user) {
            return redirect('/login');
        }

        $notification = $user->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead()
    {
        $user = $this->getAuthenticatedUser();
        
        if (!$user) {
            return redirect('/login');
        }

        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    private function getAuthenticatedUser()
    {
        if (session('clientID')) {
            return \App\Models\Client::find(session('clientID'));
        } elseif (session('freelancerID')) {
            return \App\Models\Freelancer::find(session('freelancerID'));
        }

        return null;
    }
}
