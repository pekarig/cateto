<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInteraction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactInteractionController extends Controller
{
    /**
     * Log contact page interaction (checkbox vagy accept button)
     */
    public function logInteraction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:checkbox_checked,accept_button_clicked',
        ]);

        try {
            ContactInteraction::create([
                'action' => $validated['action'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->session()->getId(),
                'referrer' => $request->header('referer'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interaction logged successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log interaction'
            ], 500);
        }
    }
}
