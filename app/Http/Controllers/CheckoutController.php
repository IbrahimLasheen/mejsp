<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Conferences;
use Illuminate\Http\Request;
use App\Models\JournalsResearches;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\NotificationsCheckoutMail;
use App\Models\InternationalPublicationOrders;
use App\Models\Invoices;
use Illuminate\Contracts\Encryption\DecryptException;

class CheckoutController extends Controller
{
    public function checkout_conference($id)
    {
        $pageTitle = 'دفع فاتورة حضور مؤتمر';
        $row = Conferences::with(['confCategory'])->where("user_id", getAuth('user', 'id'))->where('id', $id)->where("payment_response", '0')->first();
        if (empty($row)) {
            return redirect(userPrefix() . '/conference');
        }
        if ($row->payment_response > 0) {
            return redirect(userPrefix() . '/conference');
        }
        return view("main.user.conference.checkout", compact('pageTitle', 'row'));
    }
    public function checkout_conference_response(Request $request)
    {
        if ($request->status == "COMPLETED") {
            $responseCode = 'APPROVED';
        }
        $row = Conferences::orderBy('id', 'DESC')->select('payment_response', 'id')->where("user_id", getAuth('user', 'id'))->where('id', $request->id)->first();
        if (!empty($row)) {
            Payment::create(["payment_by" => getAuth("user", 'id'), "amount" => $request->amount, "currency" => "USD", "source" => "Paypal", "payment_id" => $request->payment_id, "status" => $responseCode, 'payer_email' => $request->payer_email, 'payer_name' => $request->payer_name, 'payer_id' => $request->payer_id, "for_conference" => $row->id,]);
            $row->payment_response = "1";
            $row->save();
            $info = ['price' => $request->amount, 'source' => "PayPal", 'username' => getAuth('user', 'name'), 'email' => getAuth('user', 'email'),];
            foreach (DB::table('received_emails')->select("email")->get() as $email) {
                Mail::to($email)->send(new NotificationsCheckoutMail($info));
            }
        }
    }
    public function checkout_international_publishing($id)
    {
        $pageTitle = 'دفع فاتورة طلب نشر دولي';
        $row = InternationalPublicationOrders::with(['journal'])->where("user_id", getAuth('user', 'id'))->where("payment_response", '0')->where('id', $id)->first();
        if (empty($row)) {
            return redirect(userPrefix() . '/international-publishing');
        }
        if ($row->payment_response > 0) {
            return redirect(userPrefix() . '/international-publishing');
        }
        return view("main.user.international-publishing.checkout", compact('pageTitle', 'row'));
    }
    public function checkout_international_publishing_response(Request $request)
    {
        if ($request->status == "COMPLETED") {
            $responseCode = 'APPROVED';
        }
        $row = InternationalPublicationOrders::orderBy('id', 'DESC')->select('payment_response', 'id')->where("user_id", getAuth('user', 'id'))->where('id', $request->id)->first();
        if (!empty($row)) {
            Payment::create(["payment_by" => getAuth("user", 'id'), "amount" => $request->amount, "currency" => "USD", "source" => "Paypal", "payment_id" => $request->payment_id, "status" => $responseCode, 'payer_name' => $request->payer_name, 'payer_email' => $request->payer_email, 'payer_id' => $request->payer_id, "for_international_publishing" => $row->id,]);
            $row->payment_response = "1";
            $row->save();
            $info = ['price' => $request->amount, 'source' => "PayPal", 'username' => getAuth('user', 'name'), 'email' => getAuth('user', 'email'),];
            foreach (DB::table('received_emails')->select("email")->get() as $email) {
                Mail::to($email)->send(new NotificationsCheckoutMail($info));
            }
        }
    }
    public function checkout_researches($id)
    {
        $pageTitle = 'شراء بحث';
        try {
            $id = Crypt::decryptString($id);
            $row = JournalsResearches::with(['journal', 'version'])->whereNotNull("price")->where("id", $id)->first();
            if (empty($row)) {
                return redirect(userPrefix());
            }
            return view("main.user.researches.checkout", compact('pageTitle', 'row'));
        } catch (DecryptException $e) {
            return redirect(userPrefix());
        }
    }
    public function checkout_researches_response(Request $request)
    {
        $id = $request->id;
        try {
            $id = Crypt::decryptString($id);
            if ($request->status == "COMPLETED") {
                $responseCode = 'APPROVED';
            }
            $row = JournalsResearches::select('id')->whereNotNull("price")->where('id', $id)->first();
            if (!empty($row)) {
                Payment::create(["payment_by" => getAuth("user", 'id'), "amount" => $request->amount, "currency" => "USD", "source" => "Paypal", "payment_id" => $request->payment_id, "status" => $responseCode, 'payer_name' => $request->payer_name, 'payer_email' => $request->payer_email, 'payer_id' => $request->payer_id, "for_research" => $row->id,]);
                $info = ['price' => $request->amount, 'source' => "PayPal", 'username' => getAuth('user', 'name'), 'email' => getAuth('user', 'email'),];
                foreach (DB::table('received_emails')->select("email")->get() as $email) {
                    Mail::to($email)->send(new NotificationsCheckoutMail($info));
                }
            }
        } catch (DecryptException $e) {
            return redirect(userPrefix());
        }
    }
    public function checkout_invoice_response(Request $request)
    {
        $id = $request->id;
        try {
            $id = Crypt::decryptString($id);
            if ($request->status == "COMPLETED") {
                $responseCode = 'APPROVED';
            }
            $row = Invoices::select('id')->where('id', $id)->where("payment_response", '0')->first();
            if (!empty($row)) {
                Payment::create(["payment_by" => NULL, "amount" => $request->amount, "currency" => "USD", "source" => "Paypal", "payment_id" => $request->payment_id, "status" => $responseCode, 'payer_email' => $request->payer_email, 'payer_name' => $request->payer_name, 'payer_id' => $request->payer_id, "for_invoice" => $row->id,]);
                $info = ['price' => $request->amount, 'source' => "PayPal", 'username' => $request->payer_name, 'email' => $request->payer_email,];
                $row->payment_response = "1";
                $row->save();
                foreach (DB::table('received_emails')->select("email")->get() as $email) {
                    Mail::to($email)->send(new NotificationsCheckoutMail($info));
                }
            }
        } catch (DecryptException $e) {
        }
    }
}
