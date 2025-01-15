<?php

namespace App\Exports;

use App\Models\Entrega;
use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EntregaExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $entregas = Entrega::with(['empleado', 'venta'])
        ->when($this->startDate == $this->endDate, function ($query) {
            // Si las fechas son iguales, filtra las ventas por el mismo día
            $query->whereDate('created_at', $this->startDate);
        }, function ($query) {
            // Si las fechas son diferentes, filtra por el rango completo
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        })
        ->get();
    

        return view('exports.entregas', compact('entregas'));
    }
}
