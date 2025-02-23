<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VentaGenerada extends Notification
{
    use Queueable;

    protected $venta;

    public function __construct($venta)  
    {
        $this->venta = $venta;
    }

    public function via($notifiable)
    {
        // Puedes usar otras vías de notificación como database o SMS
        return ['database'];
    }

    

    public function toArray($notifiable)
    {
        return [
            'venta_id' => $this->venta->id,
            'monto_total' => $this->venta->monto_total,
            'fecha' => $this->venta->created_at,
            'message' => 'Se ha generado una nueva venta online.',
            'type' => 'Venta Online', // Tipo de notificación
            'url' => url('/ventas/' . $this->venta->id)
          
        ];
    }
}
