<?php

namespace App\Livewire\Tools;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceGenerator extends Component
{
    use WithFileUploads;

    public $invoice_number;
    public $invoice_date;
    public $logo;
    public $seller_name;
    public $seller_address;
    public $seller_email;
    public $seller_phone;
    public $buyer_name;
    public $buyer_address;
    public $buyer_email;
    public $buyer_phone;
    public $description;
    public $items = [];
    public $item_name;
    public $item_quantity;
    public $item_price;
    public $item_total;
    public $discount;
    public $tax;
    public $notes;

    public function updated($field)
    {
        $this->validateOnly($field, [
            'item_name' => 'required|string',
            'item_quantity' => 'required|integer|min:1',
            'item_price' => 'required|numeric|min:0',
        ]);

        if ($field === 'item_price' || $field === 'item_quantity') {
            $this->item_total = $this->item_quantity * $this->item_price;
        }
    }

    public function addItem()
    {
        $this->validate([
            'item_name' => 'required|string',
            'item_quantity' => 'required|integer|min:1',
            'item_price' => 'required|numeric|min:0',
        ]);

        $this->items[] = [
            'name' => $this->item_name,
            'quantity' => $this->item_quantity,
            'price' => $this->item_price,
            'total' => $this->item_total,
        ];

        $this->reset(['item_name', 'item_quantity', 'item_price', 'item_total']);
    }

    public function submitInvoice()
    {
        $this->validate([
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'seller_name' => 'required|string',
            'seller_address' => 'required|string',
            'seller_email' => 'required|email',
            'seller_phone' => 'required|string',
            'buyer_name' => 'required|string',
            'buyer_address' => 'required|string',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required|string',
            'description' => 'nullable|string',
            'items' => 'required|array',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Emit event to show the invoice popup
        $this->emit('showInvoicePopup');
    }

    public function render(): Application|Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.tools.invoice-generator');
    }
}
