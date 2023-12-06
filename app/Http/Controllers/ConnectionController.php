<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connection;
use App\User;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function sendRequest(User $user)
    {
        $requesterId = Auth::id();
        $connection = Connection::firstOrNew([
            'user_id' => $requesterId,
            'connected_user_id' => $user->id,
        ]);

        $connection->status = 'pending';
        $connection->save();

        return response()->json(['message' => 'Connection request sent successfully', 'type' => 'success']);
    }

    public function acceptRequest($id)
    {
        $connection = Connection::where('id', $id)->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->status = 'accepted';
            $connection->save();
            return redirect()->back()->with('message', 'Connection request accepted');
        }

        return response()->json(['error' => 'Connection request not found']);
    }

    public function rejectRequest($id)
    {
        $connection = Connection::where('id', $id)->first();

        if ($connection) {
            $connection->delete();
            return redirect()->back()->with('message', 'Connection request rejected');
        }

        return response()->json(['error' => 'Connection request not found']);
    }

    public function pendingRequest()
    {
        $connections = Connection::where('connected_user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('back-end.freelancer.connection.invitations', compact('connections'));
    }

    public function myConnections()
    {
        $connections = Connection::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('connected_user_id', Auth::id());
        })
            ->where('status', 'accepted')
            ->get();
        foreach ($connections as $connect) {
            if ($connect->connected_user_id == Auth::id()) {
                $connect->connected = $connect->user;
            } else {
                $connect->connected = $connect->connected;
            }
        }


        return view('back-end.freelancer.connection.index', compact('connections'));
    }
}
