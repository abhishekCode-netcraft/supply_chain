<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    protected $items;
    protected $tab;

    public function __construct($items, $tab)
    {
        $this->items = $items;
        $this->tab = $tab;
    }

    public function view(): View
    {
        return view('exports.orders-without-image', [
            'items' => $this->items,
            'tab'   => $this->tab
        ]);
    }
}
