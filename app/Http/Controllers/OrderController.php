<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Gig;
use App\Models\Client;
use App\Models\Freelancer;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderAccepted;
use App\Notifications\OrderRejected;
use App\Notifications\DeliverySubmitted;
use App\Notifications\RevisionRequested;
use App\Notifications\OrderCompleted;

class OrderController extends Controller
{
    /**
     * Store a new order (Step 2.1 - Client places order)
     */
    public function store(Request $request, $gigId)
    {
        $request->validate([
            'requirements' => 'required|string|min:10',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today'
        ]);

        $gig = Gig::findOrFail($gigId);

        $order = Order::create([
            'gig_id' => $gig->id,
            'client_id' => session('clientID'),
            'freelancer_id' => $gig->freelancer_id,
            'status' => 'pending',
            'requirements' => $request->requirements,
            'budget' => $request->budget,
            'deadline' => $request->deadline
        ]);

        // Notify Freelancer
        if($order->freelancer){
             $order->freelancer->notify(new OrderPlaced($order));
        }

        return redirect()->route('client.orders')->with('success', 'Order placed successfully! The freelancer will be notified.');
    }

    /**
     * Freelancer accepts order (Step 3.2)
     */
    public function accept($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Authorization check
        if ($order->freelancer_id !== session('freelancerID')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $order->update(['status' => 'in_progress']);

        // Notify Client
        if($order->client){
            $order->client->notify(new OrderAccepted($order));
        }

        return redirect()->route('freelancer.orders')->with('success', 'Order accepted! You can now start working on it.');
    }

    /**
     * Freelancer rejects order (Step 3.1)
     */
    public function reject($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Authorization check
        if ($order->freelancer_id !== session('freelancerID')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $order->update(['status' => 'rejected']);

        // Notify Client
        if($order->client){
             $order->client->notify(new OrderRejected($order));
        }

        return redirect()->route('freelancer.orders')->with('success', 'Order rejected.');
    }

    /**
     * Freelancer submits delivery (Step 4.1)
     */
    public function submitDelivery(Request $request, $orderId)
    {
        $request->validate([
            'delivery_message' => 'required|string|min:10',
            'delivery_url' => 'nullable|url',
            'delivery_files.*' => 'nullable|file|max:10240' // 10MB max per file
        ]);

        $order = Order::findOrFail($orderId);

        // Authorization check
        if ($order->freelancer_id !== session('freelancerID')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Handle file uploads
        $filePaths = [];
        if ($request->hasFile('delivery_files')) {
            foreach ($request->file('delivery_files') as $file) {
                $filePaths[] = $file->store('deliveries', 'public');
            }
        }

        // Get current revision number
        $revisionNumber = $order->deliveries()->max('revision_number') ?? 0;
        if ($order->status === 'revision_requested') {
            $revisionNumber++;
        }

        Delivery::create([
            'order_id' => $order->id,
            'delivery_url' => $request->delivery_url,
            'delivery_files' => $filePaths,
            'delivery_message' => $request->delivery_message,
            'revision_number' => $revisionNumber,
            'status' => 'submitted'
        ]);

        $order->update(['status' => 'delivered']);

        // Notify Client
        if($order->client){
             $order->client->notify(new DeliverySubmitted($order));
        }

        return redirect()->route('freelancer.orders')->with('success', 'Delivery submitted successfully!');
    }

    /**
     * Client accepts delivery (Step 5.1.1)
     */
    public function acceptDelivery($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Authorization check
        if ($order->client_id !== session('clientID')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $latestDelivery = $order->latestDelivery;
        if ($latestDelivery) {
            $latestDelivery->update(['status' => 'accepted']);
        }

        $order->update(['status' => 'completed']);

        // Notify Freelancer
        if($order->freelancer){
             $order->freelancer->notify(new OrderCompleted($order));
        }

        return redirect()->route('client.orders')->with('success', 'Delivery accepted! Order completed.');
    }

    /**
     * Client requests revision (Step 5.2.1)
     */
    public function requestRevision(Request $request, $orderId)
    {
        $request->validate([
            'revision_notes' => 'required|string|min:10'
        ]);

        $order = Order::findOrFail($orderId);

        // Authorization check
        if ($order->client_id !== session('clientID')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $latestDelivery = $order->latestDelivery;
        if ($latestDelivery) {
            $latestDelivery->update(['status' => 'revision_requested']);
        }

        $order->update([
            'status' => 'revision_requested',
            'requirements' => $order->requirements . "\n\n--- Revision Request ---\n" . $request->revision_notes
        ]);

        // Notify Freelancer
        if($order->freelancer){
             $order->freelancer->notify(new RevisionRequested($order));
        }

        return redirect()->route('client.orders')->with('success', 'Revision requested. The freelancer will be notified.');
    }

    /**
     * View client's orders
     */
    public function clientOrders()
    {
        $orders = Order::with(['gig', 'freelancer', 'latestDelivery'])
            ->where('client_id', session('clientID'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.orders', compact('orders'));
    }

    /**
     * View freelancer's orders
     */
    public function freelancerOrders()
    {
        $orders = Order::with(['gig', 'client', 'latestDelivery'])
            ->where('freelancer_id', session('freelancerID'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('freelancer.orders', compact('orders'));
    }
}
