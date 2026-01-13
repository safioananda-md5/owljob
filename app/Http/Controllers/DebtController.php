<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Debt;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::orderBy('created_at', 'desc')->get();
        $debtsArr = [];
        foreach ($debts as $debt) {
            $debtsArr[] = [
                'id' => $debt->id,
                'name' => $debt->name,
                'date' => Carbon::parse($debt->date)->translatedFormat('l, j F Y'),
                'amount' => $debt->amount,
            ];
        }
        return Inertia::render('Debt/Debt', compact(['debtsArr']));
    }

    public function add()
    {
        return Inertia::render('Debt/AddDebt');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'debtName' => 'required',
                'debtDate' => 'required',
                'debtAmount' => 'required|numeric',
            ], [
                'debtName.required' => 'Nama pengeluaran wajib diisi!',
                'debtDate.required' => 'Tanggal pengeluaran wajib diisi!',
                'debtAmount.required' => 'Jumlah pengeluaran wajib diisi!',
                'debtAmount.numeric' => 'Jumlah pengeluaran wajib angka!',
            ]);

            // dd($request->debtDate);

            DB::beginTransaction();
            Debt::create([
                'name' => $request->debtName,
                'date' => $request->debtDate,
                'amount' => $request->debtAmount,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Hutang berhasil ditambahkan!',
            ], 201);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $allErrors = collect($errors)->flatten()->implode('<br> • ');
            return response()->json([
                'success' => false,
                'message' => 'Inputan Gagal! Periksa kembali isian Anda. <br> • ' . $allErrors,
            ], 400);
        } catch (Throwable $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Inputan Gagal! Periksa kembali isian Anda. <br> ' . $e->getMessage(),
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ], [
                'id.required' => 'Data id tidak ditemukan!',
            ]);

            DB::beginTransaction();
            Debt::where('id', $request->id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Hutang dihapus!',
            ], 201);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $allErrors = collect($errors)->flatten()->implode('<br> • ');
            return response()->json([
                'success' => false,
                'message' => 'Inputan Gagal! Periksa kembali isian Anda. <br> • ' . $allErrors,
            ], 400);
        } catch (Throwable $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Inputan Gagal! Periksa kembali isian Anda. <br> ' . $e->getMessage(),
            ], 400);
        }
    }
}
