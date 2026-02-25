<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; //para generar UUIDs automáticamente

class EmailTracking extends Model
{
    use HasFactory, HasUuids;


    protected $table = 'email_tracking';

    /**
     * Define qué columnas se pueden llenar mediante EmailTracking::create()
     */
    protected $fillable = [
        'tracking_uuid',
        'email_id',
        'recipient_email',
        'sended_at',
        'opened_at',
        'ip_address',
        'user_agent'
    ];

    /**
     * Indicamos a Laravel que genere el UUID en nuestra columna personalizada
     */
    public function uniqueIds(): array
    {
        return ['tracking_uuid'];
    }
}
