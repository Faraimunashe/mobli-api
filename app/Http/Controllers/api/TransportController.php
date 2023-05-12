<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $trans = Transport::join('services', 'services.id', '=', 'transports.service_id')
            ->select('transports.id', 'services.name as service', 'transports.from', 'transports.to', 'transports.departure', 'transports.arrival', 'transports.capacity', 'transports.phone')
        ->get();

        $response = [
            'transports' => $trans,
        ];

        return response($response, 200);
    }

    public function add(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'integer'],
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
            'departure' => ['required'],
            'arrival' => ['required'],
            'capacity' => ['required', 'integer'],
            'phone' => ['required', 'string']
        ]);

        $trans = new Transport();
        $trans->service_id = $request->service_id;
        $trans->from = $request->from;
        $trans->to = $request->to;
        $trans->departure = $request->departure;
        $trans->arrival = $request->arrival;
        $trans->capacity = $request->capacity;
        $trans->phone = $request->phone;
        $trans->save();

        $response = [
            'transports' => $trans,
        ];

        return response($response, 200);
    }

    public function add_service(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->phone = $request->phone;
        $service->save();

        $response = [
            'service' => $service,
        ];

        return response($response, 200);
    }

    public function one($id)
    {
        $trans = Transport::join('services', 'services.id', '=', 'transports.service_id')
            ->where('transports.id', $id)
            ->select('transports.id', 'services.name as service', 'transports.from', 'transports.to', 'transports.departure', 'transports.arrival', 'transports.capacity', 'transports.phone')
        ->first();
        if(is_null($trans))
        {
            $response = [
                'message' => "record is null",
            ];

            return response($response, 404);
        }

        $response = [
            'transport' => $trans,
        ];

        return response($response, 200);
    }
}
