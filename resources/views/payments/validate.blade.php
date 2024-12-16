@extends('layouts.app')

@section('content')
<h1>Validasi Pembayaran</h1>
@foreach ($payments as $payment)
    <div>
        <p>Order ID: {{ $payment->order_id }}</p>
        <p>Metode: {{ $payment->method }}</p>
        <p>Status: {{ $payment->status }}</p>
        <form action="{{ route('payments.approve', $payment->id) }}" method="POST">
            @csrf
            <button type="submit" name="action" value="approved" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Setujui Pembayaran
            </button>
            <button type="submit" name="action" value="rejected" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-4">
                Tolak Pembayaran
            </button>
        </form>        
    </div>
@endforeach
@endsection