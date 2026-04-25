<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Services\PaymentService;
use App\Models\Payment;


class PaymentController extends Controller
{

    public function __construct(protected PaymentService $service){
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = $this->service->getAll();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('payments.form', [ 'payment' => new Payment() ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $payment = $this->service->find($id);
        return view('payments.form', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, int $id)
    {
        $payment = $this->service->find($id);
        $payment->update($request->validated());
        $this->service->update($payment);
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
