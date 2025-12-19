<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceSettings;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Order;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoice.manage', ['only' => ['index','update']]);
    }
    //---------------------------- invoice index code start ----------------------------
    public function index()
    {
        $settings = InvoiceSettings::firstOrNew();
        return view('admin.invoice.index', compact('settings'));
    }
    //---------------------------- invoice index code end ----------------------------

    //---------------------------- invoice update code start ----------------------------
    public function update(Request $request)
    {
        try{
            $settings = InvoiceSettings::firstOrNew();

            // Validate the incoming request data
            $validated = $request->validate([
                'site_name' => 'required|string|max:255',
                'header_message' => 'required|string',
                'footer_message' => 'required|string',
                'contact_address' => 'required|string|max:255',
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'required|string|max:15',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'show_logo' => 'boolean',
                'show_signature' => 'boolean',
                'status' => 'boolean',
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_logo.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/invoice/logo'), $filename);

                // Delete the old logo if it exists
                if ($settings->logo) {
                    $existingImagePath = public_path('images/invoice/logo/' . $settings->logo);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $settings->logo = $filename;
            }

            // Handle signature upload
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $filename = time() . '_signature.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/invoice/signature'), $filename);

                // Delete the old signature if it exists
                if ($settings->signature) {
                    $existingImagePath = public_path('images/invoice/signature/' . $settings->signature);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $settings->signature = $filename;
            }

            // Handle checkbox inputs
            $settings->show_logo = $request->has('show_logo');
            $settings->show_signature = $request->has('show_signature');
            $settings->status = $request->has('status');

            // Update other fields
            $settings->site_name = $validated['site_name'];
            $settings->header_message = $validated['header_message'];
            $settings->footer_message = $validated['footer_message'];
            $settings->contact_address = $validated['contact_address'];
            $settings->contact_email = $validated['contact_email'];
            $settings->contact_phone = $validated['contact_phone'];

            // Save the settings
            $settings->save();

            return redirect()->back()->with('success', 'Invoice settings updated successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the invoice setting: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------- invoice update code end ----------------------------

    //--------------------------- invoice front page code start -----------------------
    public function front_invoice($user_slug, $transaction_id)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();

        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $transaction = Order::where('transaction_id', $transaction_id)
                            ->where('user_id', $user->id)
                            ->firstOrFail();

        $setting = GeneralSetting::first();
        $invoice = InvoiceSettings::first();

        return view('front.invoice', compact('user', 'setting', 'invoice', 'transaction'));
    }
    //--------------------------- invoice front page code end -----------------------

    //--------------------------- invoice pdf download code start -----------------------
    public function downloadPdf($user_slug,$transaction_id)
    {
        $user = User::where('slug', $user_slug)->firstOrFail();
        $transaction = Order::where('transaction_id', $transaction_id)
                            ->where('user_id', $user->id)
                            ->firstOrFail();
        $invoice = InvoiceSettings::first();
        $pdf = Pdf::loadView('front.pdfs.invoice_pdf', compact('user', 'transaction','invoice'));
        return $pdf->download('invoice_'.$transaction_id.'.pdf');
    }
    //--------------------------- invoice pdf download code end -----------------------

}
