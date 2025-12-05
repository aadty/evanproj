<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Show the order index page with pending orders grouped by kategori
     */
    public function index()
    {
        $orders = Order::where('status', 'pending')->get()->groupBy('kategori');

        return view('order.index', compact('orders'));
    }

    /**
     * Show the order completed page with completed orders grouped by kategori
     */
    public function completed()
    {
        $orders = Order::where('status', 'complete')->get()->groupBy('kategori');

        return view('order.completed', compact('orders'));
    }

    /**
     * Store a newly created order via AJAX
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate input
            $validated = $request->validate([
                'kategori' => 'required|in:plat-tipis,plat-tebal,pipa',
                'nama' => 'required|string|max:255',
                'barang' => 'required|string|max:255',
            ]);

            // Generate no and kode
            $no = Order::generateNextNo();
            $kode = Order::generateKode($validated['kategori'], $no);

            // Create order
            $order = Order::create([
                'no' => $no,
                'kode' => $kode,
                'kategori' => $validated['kategori'],
                'nama' => $validated['nama'],
                'barang' => $validated['barang'],
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update the specified order via AJAX
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        try {
            // Validate input
            $validated = $request->validate([
                'kategori' => 'required|in:plat-tipis,plat-tebal,pipa',
                'nama' => 'required|string|max:255',
                'barang' => 'required|string|max:255',
            ]);

            // Update kode if kategori changed
            if ($order->kategori !== $validated['kategori']) {
                $validated['kode'] = Order::generateKode($validated['kategori'], $order->no);
            }

            // Update order
            $order->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'order' => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete the specified order (soft delete) via AJAX
     */
    public function destroy(Order $order): JsonResponse
    {
        try {
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Mark order as complete via AJAX
     */
    public function complete(Order $order): JsonResponse
    {
        try {
            $order->update(['status' => 'complete']);

            return response()->json([
                'success' => true,
                'message' => 'Order marked as complete',
                'order' => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
