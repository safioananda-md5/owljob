<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\RecentActivity;
use Throwable;
use Inertia\Inertia;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Throw_;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JobsController extends Controller
{
    public function active()
    {
        $jobs = Jobs::where('status', 'active')->get();
        return Inertia::render('Jobs/ActiveJobs', compact(['jobs']));
    }

    public function pause()
    {
        $jobs = Jobs::where('status', 'pause')->get();
        return Inertia::render('Jobs/PauseJobs', compact(['jobs']));
    }

    public function finished()
    {
        $jobs = Jobs::where('status', 'finish')->get();
        return Inertia::render('Jobs/FinishJobs', compact(['jobs']));
    }

    public function canceled()
    {
        $jobs = Jobs::where('status', 'cancel')->get();
        return Inertia::render('Jobs/CancelJobs', compact(['jobs']));
    }

    public function add()
    {
        return Inertia::render('Jobs/AddJobs');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cust_name' => 'required',
                'job_name' => 'required',
                'due_date' => 'required',
                'price' => 'required|numeric',
            ], [
                'cust_name.required' => 'Nama customer wajib diisi!',
                'job_name.required' => 'Nama pekerjaan wajib diisi!',
                'due_date.required' => 'Due date wajib diisi!',
                'price.required' => 'Harga wajib diisi!',
                'price.numeric' => 'Harga wajib angka!',
            ]);

            DB::beginTransaction();
            Jobs::create([
                'cust_name' => $request->cust_name,
                'job_name' => $request->job_name,
                'due_date' => $request->due_date,
                'price' => $request->price,
                'status' => 'active'
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan berhasil ditambahkan!',
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

    public function finish(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ], [
                'id.required' => 'Data id tidak ditemukan!',
            ]);

            DB::beginTransaction();
            $Jobs = Jobs::where('id', $request->id)->first();
            $Jobs->update([
                'status' => 'finish'
            ]);
            RecentActivity::create([
                'type' => 'income',
                'amount' => $Jobs->price,
                'user' => 'Me',
                'description' => 'Earnings',
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan berhasil diselesaikan!',
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

    public function paused(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ], [
                'id.required' => 'Data id tidak ditemukan!',
            ]);

            DB::beginTransaction();
            Jobs::where('id', $request->id)->update([
                'status' => 'pause'
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan dihentikan sementara!',
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

    public function start(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ], [
                'id.required' => 'Data id tidak ditemukan!',
            ]);

            DB::beginTransaction();
            Jobs::where('id', $request->id)->update([
                'status' => 'active'
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan berhasil dilanjutkan!',
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

    public function cancel(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ], [
                'id.required' => 'Data id tidak ditemukan!',
            ]);

            DB::beginTransaction();
            Jobs::where('id', $request->id)->update([
                'status' => 'cancel'
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan dibatalkan!',
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
