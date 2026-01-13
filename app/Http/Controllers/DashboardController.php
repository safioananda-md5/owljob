<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Expenses;
use Carbon\Carbon;
use App\Models\Jobs;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\RecentActivity;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $FinishedJobs = Jobs::where('status', 'finish')->get();
        $ActiveandPauseJobs = Jobs::whereIn('status', ['active', 'pause'])->get();
        $Revenue = 0;
        foreach ($FinishedJobs as $FinishedJob) {
            $Revenue = bcadd($Revenue, $FinishedJob->price, 2);
        }
        $Receivables = 0;
        foreach ($ActiveandPauseJobs as $ActiveandPauseJob) {
            $Receivables = bcadd($Receivables, $ActiveandPauseJob->price, 2);
        }
        $TodayActivities = RecentActivity::whereDate('created_at', Carbon::today())->get();
        $TodayActivitiesArr = [];
        if ($TodayActivities->isNotEmpty()) {
            foreach ($TodayActivities as $TodayActivitie) {
                if ($TodayActivitie->type == 'income') {
                    $TodayActivitiesArr[] = [
                        'id' => $TodayActivitie->id,
                        'invoiceNumber' => str_pad($TodayActivitie->id, 5, '0', STR_PAD_LEFT),
                        'href' => 'javascript:void(0)',
                        'amount' => $TodayActivitie->amount,
                        'tax' => 'Rp 0,00',
                        'status' => $TodayActivitie->type,
                        'client' => $TodayActivitie->user,
                        'description' => $TodayActivitie->description,
                        'icon' => 'ArrowDownCircleIcon',
                    ];
                } else if ($TodayActivitie->type == 'expenses') {
                    $TodayActivitiesArr[] = [
                        'id' => $TodayActivitie->id,
                        'invoiceNumber' => str_pad($TodayActivitie->id, 5, '0', STR_PAD_LEFT),
                        'href' => 'javascript:void(0)',
                        'amount' => $TodayActivitie->amount,
                        'tax' => 'Rp 0,00',
                        'status' => $TodayActivitie->type,
                        'client' => $TodayActivitie->user,
                        'description' => $TodayActivitie->description,
                        'icon' => 'ArrowUpCircleIcon',
                    ];
                }
            }
        } else {
            $TodayActivitiesArr[] = [
                'id' => '#',
                'invoiceNumber' => str_pad('#', 5, '#', STR_PAD_LEFT),
                'href' => 'javascript:void(0)',
                'amount' => '0',
                'tax' => 'Rp 0,00',
                'status' => 'none',
                'client' => 'none',
                'description' => 'Tidak ada aktivitas',
                'icon' => 'none',
            ];
        }
        $NotTodayActivities = RecentActivity::whereDate('created_at', '!=', Carbon::today())->get();
        $NotTodayActivitiesArr = [];
        if ($NotTodayActivities->isNotEmpty()) {
            foreach ($NotTodayActivities as $NotTodayActivitie) {
                if ($NotTodayActivitie->type == 'income') {
                    $NotTodayActivitiesArr[] = [
                        'id' => $NotTodayActivitie->id,
                        'invoiceNumber' => str_pad($NotTodayActivitie->id, 5, '0', STR_PAD_LEFT),
                        'href' => 'javascript:void(0)',
                        'amount' => $NotTodayActivitie->amount,
                        'tax' => 'Rp 0,00',
                        'status' => $NotTodayActivitie->type,
                        'client' => $NotTodayActivitie->user,
                        'description' => $NotTodayActivitie->description,
                        'icon' => 'ArrowDownCircleIcon',
                    ];
                } else if ($NotTodayActivitie->type == 'expenses') {
                    $NotTodayActivitiesArr[] = [
                        'id' => $NotTodayActivitie->id,
                        'invoiceNumber' => str_pad($NotTodayActivitie->id, 5, '0', STR_PAD_LEFT),
                        'href' => 'javascript:void(0)',
                        'amount' => $NotTodayActivitie->amount,
                        'tax' => 'Rp 0,00',
                        'status' => $NotTodayActivitie->type,
                        'client' => $NotTodayActivitie->user,
                        'description' => $NotTodayActivitie->description,
                        'icon' => 'ArrowUpCircleIcon',
                    ];
                }
            }
        } else {
            $NotTodayActivitiesArr[] = [
                'id' => '#',
                'invoiceNumber' => str_pad('#', 5, '#', STR_PAD_LEFT),
                'href' => 'javascript:void(0)',
                'amount' => '0',
                'tax' => 'Rp 0,00',
                'status' => 'none',
                'client' => 'none',
                'description' => 'Tidak ada aktivitas',
                'icon' => 'none',
            ];
        }
        $Espenses = Expenses::all();
        $TotalEspenses = 0;
        foreach ($Espenses as $Espense) {
            $TotalEspenses = bcadd($TotalEspenses, $Espense->amount, 2);
        }
        $Debts = Debt::all();
        $TotalDebts = 0;
        foreach ($Debts as $Debt) {
            $TotalDebts = bcadd($TotalDebts, $Debt->amount, 2);
        }
        return Inertia::render('Dashboard', compact(['Revenue', 'Receivables', 'TotalEspenses', 'TotalDebts', 'TodayActivitiesArr', 'NotTodayActivitiesArr']));
    }
}
