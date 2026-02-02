<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use App\Models\PurchaseBillSchedule;
use Illuminate\Support\Facades\DB;

class PayBillsSchedulesController extends Controller
{
    
    public function index()
    {
        $schedules = PaymentSchedule::where('status', 'pending')
            ->with('bill.supplier')
            ->get();

        return view('pay_bills.schedules.index', compact('schedules'));
    }

    public function create()
    {
        // Bills approved but not yet scheduled or partially scheduled
        $bills = PurchaseBill::with(['receipt.purchaseOrder.supplier', 'items'])
                    ->where('approval_status', 'Approved')
                    ->where('balance', '>', 0)
                    ->whereDoesntHave('schedules', function($query) {
                        $query->where('status', 'Pending'); // o bisan unsa nga status nga nagpasabot nga naa na schedule
                    })
                    ->orderBy('due_date','asc')
                    ->get();

        return view('pay_bills.schedules.create', compact('bills'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'bills' => 'required|array',
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->bills as $billId) {
                $bill = PurchaseBill::find($billId);
                if ($bill && $bill->balance > 0) {
                    PurchaseBillSchedule::create([
                        'bill_id' => $bill->id,
                        'scheduled_date' => $request->payment_date,
                        'scheduled_amount' => $bill->balance,
                        'status' => 'Pending',
                        'created_by' => auth()->user()->name ?? 'system',
                        'remarks' => null,
                    ]);
                }
            }
        });


        return redirect()->route('pay_bills.schedules.create')
                        ->with('success', 'Schedules created successfully.');
    }




}
