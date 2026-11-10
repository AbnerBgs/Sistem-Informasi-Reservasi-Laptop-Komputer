<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    // menampilkan landing page /  form reservasi 
    public function index() {
        return view('guest.index');
    }

    // menyimpan data reservasi dan redirect ke WA admin
    public function store (Request $request) {
        $request->validate([
            'customer_name'         => 'required | string | max:255',
            'customer_phone'        => 'required | string | max:255',
            'device_type'           => 'required | in:Laptop,PC',
            'device_brand'          => 'required | string | max:100',
            'problem_description'   => 'required | string'
        ]);

        // generate kode tiket untuk di track
        $ticketCode = 'TK-' . date('Ymd') . '-' .strtoupper(substr(uniqid(), -4));

        $services = Service::create ([
            'ticket_code'           => $ticketCode,
            'customer_name'         => $request->customer_name,
            'customer_phone'        => $request->customer_phone,
            'device_type'           => $request->device_type,
            'device_brand'          => $request->device_brand,
            'problem_description'   => $request->problem_description,
            'status'                => 'pending',
        ]);

        $adminWA = '6282310276459';

        $message = "Halo Admin, saya ingin konfirmasi reservasi service:\n\n"
                 . "*No. Tiket:* {$services->ticket_code}\n"
                 . "*Nama:* {$services->customer_name}\n"
                 . "*Perangkat:* {$services->device_type} ({$services->device_brand})\n"
                 . "*Kendala:* {$services->problem_description}";

        $waUrl = "https://wa.me/($adminWA)?text=" . urlencode($message);

        return redirect()->away($waUrl);
    }

    public function tracking(Request $request) {
        $service = null;
        if($request->has('ticket_code')) {
            $service = Service::where('ticket_code', $request->tircket_code)->first();
        }

        return view('geust.tracking', compact('service'));
    }
}
