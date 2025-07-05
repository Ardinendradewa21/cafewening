<?php

namespace App\Http\Controllers;

use id;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Menyimpan transaksi baru dari proses checkout
     */
    public function store(Request $request)
    {
        try {
            // Validasi data yang diterima
            $request->validate([
                'cart' => 'required|array|min:1',
                'cart.*.id' => 'required|integer|exists:products,id',
                'cart.*.quantity' => 'required|integer|min:1',
                'cart.*.price' => 'required|numeric|min:0',
                'cart.*.name' => 'required|string'
            ]);

            $cart = $request->input('cart');

            // Mulai database transaction
            DB::beginTransaction();

            // Hitung total amount
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Buat kode transaksi unik
            $transactionCode = 'TRX-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Simpan data transaksi utama
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'total_amount' => $totalAmount,
                'user_id' => auth()->id(), // ID user yang sedang login
                'status' => 'baru', // Status awal
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Simpan detail transaksi dan update stok produk
            foreach ($cart as $item) {
                // Cek stok produk
                $product = Product::find($item['id']);
                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item['id']} tidak ditemukan");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }

                // Simpan detail transaksi
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Update stok produk
                $product->decrement('stock', $item['quantity']);
            }

            // Commit transaksi
            DB::commit();

            // Log untuk debugging
            Log::info('Transaksi berhasil disimpan', [
                'transaction_id' => $transaction->id,
                'transaction_code' => $transactionCode,
                'total_amount' => $totalAmount,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'transaction_code' => $transactionCode,
                    'total_amount' => $totalAmount
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();

            // Log error untuk debugging
            Log::error('Error saat menyimpan transaksi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'cart_data' => $cart ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}