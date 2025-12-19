<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialChat;

class SocialChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:chat.manage', ['only' => ['index','store','show']]);
    }
    //----------------------------------  View Code start-------------------------------
    public function index()
    {
        return view('admin.project-settings.chat');
    }
    //----------------------------------  View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
        $request->validate([
        'contact' => 'numeric',
        ]);

        $socialchat = SocialChat::firstOrNew();
        $socialchat->header_title = $request->input('header_title');
        $socialchat->contact = $request->input('contact');
        $socialchat->wp_msg = $request->input('wp_msg');
        $socialchat->wp_color = $request->input('wp_color');
        $socialchat->button_position = $request->has('button_position')? 1 : 0;
        $socialchat->whatsapp_enable_button = $request->has('whatsapp_enable_button')? 1 : 0 ;
        $socialchat->facebook_chat_bubble = $request->input('facebook_chat_bubble');
        $socialchat->save();
        return redirect('admin/chat-setting')->with('success', 'Data has been added.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the code: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request)
    {
        $socialchat = SocialChat::first();
        return view('admin.project-settings.chat', compact('socialchat'));
    }
    //---------------------------------- All Data Show Code end-------------------------------
}
