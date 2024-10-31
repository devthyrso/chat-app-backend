<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages($userId)
    {
        $authUserId = Auth::id();

        $messages = Chat::where(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $authUserId)
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $authUserId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(['messages' => $messages]);
    }

    public function store(Request $request)
    {
        try {
            $senderUser = User::findOrFail($request->sender_id);

            $message = Chat::create([
                'message' => $request->message,
                'type' => $request->type,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
            ]);

            $message->formatted_created_at = $this->formatDate($message->created_at);
            $message->name = $senderUser->name;

            $requestBody = [
                'receiverId' => $request->receiver_id,
                'senderId' => $request->sender_id,
                'message' => $message,
            ];

            Http::post(env('API_CHAT_SOCKET_URL', 'http://localhost:7000') . '/message/send', $requestBody);

            return response(['message' => $message], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao enviar mensagem'], 500);
        }
    }

    public function list_messages_by_friend($logged_user, $friend)
    {
        try {
            $messages = Chat::whereIn('sender_id', [$logged_user, $friend])
                ->whereIn('receiver_id', [$logged_user, $friend])
                ->get()
                ->map(function($message) {
                    $message->formatted_created_at = $this->formatDate($message->created_at);
                    return $message;
                });
            
            return response(['messages' => $messages], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar mensagens'], 500);
        }
    }

    public function readMessages(Request $request)
    {
        try {
            $messages_to_read = Chat::where('sender_id', $request->friend)
                ->where('receiver_id', $request->logged_user)
                ->where('readed', false)
                ->update(['readed' => true]);

            return response(['success' => $messages_to_read . ' mensagens lidas'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao marcar mensagens como lidas'], 500);
        }
    }

    private function formatDate($createdAt)
    {
        $createdAt = Carbon::parse($createdAt)->timezone('America/Sao_Paulo');

        if ($createdAt->isToday()) {
            return 'Hoje ' . $createdAt->format('H:i');
        } else {
            return $createdAt->format('d/m/Y H:i');
        }
    }
}
