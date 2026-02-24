<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTracking; // El modelo que crearás
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function track(Request $request, $emailUuid)
    {
        try {
            // Buscar o crear el registro de tracking
            $tracking = EmailTracking::firstOrNew(['email_uuid' => $emailUuid]);
            
            // Solo registrar si no se había abierto antes
            if (!$tracking->opened_at) {
                $tracking->opened_at = now();
                $tracking->ip_address = $request->ip();
                $tracking->user_agent = $request->userAgent();
                $tracking->save();
                
                Log::info("Correo {$emailUuid} abierto desde IP: {$request->ip()}");
                
                // Aquí puedes disparar eventos, notificaciones, etc.
                // event(new EmailOpened($tracking));
            }

            // Devolver una imagen transparente de 1x1
            $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            
            return response($pixel, 200)
                ->header('Content-Type', 'image/gif')
                ->header('Content-Length', strlen($pixel))
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            Log::error("Error en tracking: " . $e->getMessage());
            // Siempre devolver una imagen, aunque falle el registro
            return response()->file(public_path('img/1x1.png'));
        }
    }
}

