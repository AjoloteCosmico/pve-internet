<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ExampleMail;
use App\Jobs\SendBulkEmails;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Enviar un solo email.
     */

    public function send_test(){
        $data = [
            'subject' => 'asunto de prueba',
            'message' => 'mensaje de prueba, aki probando',
        ];

        Mail::to('felmiquiztli@gmail.com')->send(new ExampleMail($data));
        return response()->json(['message' => 'Email enviado exitosamente.']);

    }
    public function sendSingle(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = [
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to($request->email)->send(new ExampleMail($data));

        return response()->json(['message' => 'Email enviado exitosamente.']);
    }

    /**
     * Enviar emails masivos con chunks.
     */
    public function sendBulk(Request $request)
    {
        $request->validate([
            'emails' => 'required|array',
            'emails.*' => 'email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'chunk_size' => 'integer|min:1|max:100', // Tamaño del chunk, por defecto 50
        ]);

        $emails = $request->emails;
        $chunkSize = $request->chunk_size ?? 50;

        $data = [
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        // Dividir los emails en chunks y despachar jobs
        collect($emails)->chunk($chunkSize)->each(function ($chunk) use ($data) {
            SendBulkEmails::dispatch($chunk->toArray(), $data);
        });

        return response()->json(['message' => 'Emails masivos en cola para envío.']);
    }
}