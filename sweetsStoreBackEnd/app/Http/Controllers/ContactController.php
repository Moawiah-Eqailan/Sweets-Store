<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{

    public function index()
    {
        $contactMessages = ContactUs::select('user_name','user_email',  'message')->get();
    
        $contactMessages = ContactUs::all(); 
        return view('admin.Contact.Contact', compact('contactMessages'));
    }
    
    public function show($id)
    {
        $contact = ContactUs::find($id); 
    
        return view('admin.Contact.show', compact('contact'));
    }
    


    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|min:10|max:60',
            'phone' => 'required|string|min:10|max:14',
            'subject' => 'required|string|max:40',
            'message' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        ContactUs::create([
            'user_id' => Auth::id(),
            'user_name' => $request->name,
            'user_email' => $request->email,
            'user_phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'user_city' => $request->city,
            'user_state' => $request->state,
        ]);

        Log::info('Message sent to database');

        return redirect()->back()->with('success', 'Your message has been sent successfully. Thank you for contacting us');
    }


    public function showMessages()
    {
        $totalMessages = ContactUs::all();
        $Contact = $totalMessages->count(); 
    
        return view('layouts.navbar', compact('totalMessages', 'Contact'));
    }
    


    public function destroy(string $id)
    {
        
        $Contact = ContactUs::findOrFail($id);
    
       
    
        $Contact->delete();
    
        return redirect()->route('Contact')->with('success', 'Contact deleted successfully');
    }



    public function ContactUs(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactUs::create([
            'user_name' => $request->name,
            'user_email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'تم إرسال الرسالة بنجاح!',
        ]);
    }
}
