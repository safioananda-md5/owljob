<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Expenses;
use Illuminate\Http\Request;
use App\Models\RecentActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExpensesController extends Controller
{
    public function index()
    {
        $expenses = Expenses::orderBy('created_at', 'desc')->get();
        $expensesArr = [];
        foreach ($expenses as $expense) {
            $expensesArr[] = [
                'id' => $expense->id,
                'name' => $expense->name,
                'date' => Carbon::parse($expense->date)->translatedFormat('l, j F Y'),
                'amount' => $expense->amount,
            ];
        }
        return Inertia::render('Expenses/Expenses', compact(['expensesArr']));
    }

    public function add()
    {
        return Inertia::render('Expenses/AddExpenses');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'expensesName' => 'required',
                'expensesDate' => 'required',
                'expensesAmount' => 'required|numeric',
            ], [
                'expensesName.required' => 'Nama pengeluaran wajib diisi!',
                'expensesDate.required' => 'Tanggal pengeluaran wajib diisi!',
                'expensesAmount.required' => 'Jumlah pengeluaran wajib diisi!',
                'expensesAmount.numeric' => 'Jumlah pengeluaran wajib angka!',
            ]);

            // dd($request->expensesDate);

            DB::beginTransaction();
            Expenses::create([
                'name' => $request->expensesName,
                'date' => $request->expensesDate,
                'amount' => $request->expensesAmount,
            ]);
            RecentActivity::create([
                'type' => 'expenses',
                'amount' => $request->expensesAmount,
                'user' => 'Me',
                'description' => $request->expensesName,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran berhasil ditambahkan!',
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
            Expenses::where('id', $request->id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pengeluran dihapus!',
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
