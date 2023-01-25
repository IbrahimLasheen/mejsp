<?php

namespace App\Http\Controllers;

use App\Mail\InvoicesCheckoutMail;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\Journals;
use App\Models\InvoiceJournal;
use App\Models\InvoiceJournalItem;
class InvoicesController extends Controller
{

  public $ending = 15;
  private function endTime()
  {
    return time() + $this->ending * 24 * 60 * 60;
  }
  public function index()
  {
    $invoices = Invoices::with('items')->orderBy("id", 'DESC')->get();
    return view("admin.invoices.all", compact('invoices'));
  }
    public function indexJournals()
  {
    $invoices = InvoiceJournal::orderBy("id", 'DESC')->get();
    return view("admin.invoices.all-journals", compact('invoices'));
  }
  public function create()
  {
    return view("admin.invoices.create");
  }
    public function createJournals()
  {
    $journals = Journals::get();
    return view("admin.invoices.create-journals", compact('journals'));
  }
  public function storeJournal(Request $request)
  {
    // chenck if invoice exist
    $Invoice = InvoiceJournal::where('journal_id', $request->journal_id)->first();
    if ($Invoice) {
        return response(['status' => true, 'message' => 'تم اضافة فاتورة بالفعل لهذه المجله', 'form' => 'reset', 'redirect' => false,]);
    }
    $request->validate(['journal_id' => 'required', 'price' => 'required',]);
    $journal = Journals::findOrFail($request->journal_id);
    $insert = InvoiceJournal::create(["journal_id" => $journal->id]);
    if ($insert->save()) {
      for ($i = 0; $i < count($request->service_name); $i++) {
        InvoiceJournalItem::create(["service_name" => $request->service_name[$i], "price" => $request->price[$i], 'invoice_journal_id' => $insert->id]);
      }
      if (isset($request->send_mail)) {
        $info = ["link" => url("invoice/" . Crypt::encryptString($insert->id)), "service_name" => $request->service_name, 'price' => $request->price,];

        //Mail::to($request->email)->send(new InvoicesCheckoutMail($info));

      }
      return response(['status' => true, 'message' => 'تم اضافة الفاتورة بنجاح', 'form' => 'reset', 'redirect' => true, 'to' => adminUrl("invoices"),]);
    }
  }
  public function store(Request $request)
  {
    $request->validate(['email' => 'required', 'price' => 'required',]);

    $insert = Invoices::create(["email" => $request->email, "ending" => $this->endTime(),]);
    if ($insert->save()) {
      for ($i = 0; $i < count($request->service_name); $i++) {
        InvoiceItems::create(["service_name" => $request->service_name[$i], "price" => $request->price[$i], 'invoice_id' => $insert->id,]);
      }
      if (isset($request->send_mail)) {
        $info = ["link" => url("invoice/" . Crypt::encryptString($insert->id)), "service_name" => $request->service_name, 'price' => $request->price,];

        //Mail::to($request->email)->send(new InvoicesCheckoutMail($info));

      }
      return response(['status' => true, 'message' => 'تم اضافة الفاتورة بنجاح', 'form' => 'reset', 'redirect' => true, 'to' => adminUrl("invoices"),]);
    }
  }


  public function destroy(Request $request)
  {
    $row = Invoices::find($request->id);
    if (!empty($row)) {
      $row->delete();
      $request->session()->flash('successMessage', 'تم حذف الفاتورة بنجاح');
      return back();
    }
    return back();
  }
  public function edit($id)
  {
    $row = Invoices::with('items')->orderBy("id", 'DESC')->where("id", $id)->first();
    if (!empty($row)) {
      if ($row->payment_response == 0) {
        return view("admin.invoices.edit", compact('row'));
      } else {
        return redirect("");
      }
    } else {
      return redirect("");
    }
  }
    public function editJournal($id)
  {
    $row = InvoiceJournal::with('items')->orderBy("id", 'DESC')->where("id", $id)->first();
    $journals = Journals::get();
    if (!empty($row)) {
        return view("admin.invoices.edit-journal", compact('row', 'journals'));
    } else {
      return redirect("");
    }
  }
  public function update(Request $request)
  {
    $id = $request->id;
    $request->validate([
        "service_name.*" => 'required|max:1000', 
        'price.*' => 'required|numeric',
        'email' => 'required',
        
        ]);
    $update = Invoices::find($id);
    $update->email = $request->email;
    $update->ending = $this->endTime();
    $update->save();
    for ($i = 0; $i < count($request->service_name); $i++) {
      if (isset($request->item_id[$i])) {
        $item = InvoiceItems::find($request->item_id[$i]);
        if (!empty($item)) {
          $item->service_name = $request->service_name[$i];
          $item->price = $request->price[$i];
          $item->invoice_id = $id;
          $item->save();
        }
      } else {
        InvoiceItems::create(["service_name" => $request->service_name[$i], "price" => $request->price[$i], 'invoice_id' => $id,]);
      }
    }
    return response(['status' => true, 'message' => 'تم تحديث الفاتورة بنجاح',]);
  }
   public function updateJournal(Request $request)
  {
    $id = $request->id;
    $request->validate([
        "service_name.*" => 'required|max:1000', 
        'price.*' => 'required|numeric',
        'journal_id' => 'required',
        'default_page_count' => 'required|numeric',
        'extra_page_price' => 'required|numeric'
        ]);
    $update = InvoiceJournal::find($id);
    $update->journal_id = $request->journal_id;
    $update->default_page_count = $request->default_page_count;
    $update->extra_page_price = $request->extra_page_price;
    $update->save();
    
    for ($i = 0; $i < count($request->service_name); $i++) {
      if (isset($request->item_id[$i])) {
        $item = InvoiceJournalItem::find($request->item_id[$i]);

        if (!empty($item)) {
          $item->service_name = $request->service_name[$i];
          $item->price = $request->price[$i];
          $item->invoice_journal_id = $id;
          $item->save();
        }
      } else {
        InvoiceJournalItem::create(["service_name" => $request->service_name[$i], "price" => $request->price[$i], 'invoice_journal_id' => $id,]);
      }
    }
    return response(['status' => true, 'message' => 'تم تحديث الفاتورة بنجاح',]);
  }
  public function item_destory(Request $request)
  {
    $row = InvoiceItems::find($request->id);
    if (!empty($row)) {
      $row->delete();
    }
  }
  public function invoice($token_id)
  {
    try {
      $id = Crypt::decryptString($token_id);
      $row = Invoices::with('items')->where("id", $id)->where("payment_response", '0')->first();
      if (!empty($row)) {
        if (time() > $row->ending) {
          return view("pages.expiry");
        } else {
          return view("main.invoice", compact('row'));
        }
      } else {
        return view("pages.expiry");
      }
    } catch (DecryptException $e) {
      return view("pages.notfound");
    }
  }
  public function active(Request $request)
  {
    $row = Invoices::find($request->id);
    if (!empty($row)) {
      $row->ending = $this->endTime();
      $row->save();
      $request->session()->flash('successMessage', 'تم اعادة تنشيط الفاتورة بنجاح');
    }
    return back();
  }
  public function mark_as_paid($id){

    $row = Invoices::find($id);
    if (!empty($row)) {
      $row->payment_response = '1';
      $row->paid_at = now();
      $row->save();
      request()->session()->flash('successMessage', 'تم تحويل الفاتورة كمدفوعة بنجاح');
    }
    return back();
  }
  public function user_invoices(){

    $invoices = Invoices::with('items')->where('email',getAuth('user','email'))->orderBy("id", 'DESC')->get();
    return view("main.user.invoices", compact('invoices'));
  }
}
