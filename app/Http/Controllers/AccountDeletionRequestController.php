<?php

namespace App\Http\Controllers;

use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDeletionApproved;
use App\Mail\AccountDeletionRejected;
use Illuminate\Support\Facades\Auth;

class AccountDeletionRequestController extends Controller
{
    public function __construct()
    {
        // Apply middleware to ensure the user has the necessary permission to manage account deletion requests
        $this->middleware('permission:accountdelete.manage', ['only' => ['index']]);
    }

    /**
     * Display a paginated list of account deletion requests.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $requests = AccountDeletionRequest::with('user')->latest()->paginate(10);
        return view('admin.users.user_delete', compact('requests'));
    }

    /**
     * Approve an account deletion request, soft delete the user, and send an approval email.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $deletionRequest = AccountDeletionRequest::findOrFail($id);
        $user = User::find($deletionRequest->user_id);

        if ($user) {
            if (!$user->trashed()) {
                // Send email notification
                Mail::to($user->email)->send(new AccountDeletionApproved($user));

                // Soft delete the user
                $user->delete();

                // Update the deletion request status
                $deletionRequest->status = 'approved';
                $deletionRequest->delete();

                return redirect()->back()->with('success', 'Account deletion request approved and user account soft-deleted.');
            } else {
                return redirect()->back()->with('warning', 'User account already soft-deleted.');
            }
        } else {
            // Handle case where user doesn't exist
            $deletionRequest->status = 'error';
            $deletionRequest->save();
            return redirect()->back()->with('error', 'User not found. Request marked as error.');
        }
    }

    /**
     * Reject an account deletion request and send a rejection email.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $request = AccountDeletionRequest::findOrFail($id);
        $user = $request->user;

        if ($user) {
            Mail::to($user->email)->send(new AccountDeletionRejected($user));
        }

        $request->delete();

        return redirect()->back()->with('success', 'Account deletion request rejected.');
    }

}
