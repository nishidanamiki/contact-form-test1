<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $validated = $request->validated();

        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);

        $contact['tel'] = $request->tel1 . $request->tel2 . $request->tel3;

        $category = Category::find($contact['category_id']);
        $contact['category_name'] = $category ? $category->content : '選択してください';

        $categories = Category::all();

        return view('confirm', compact('contact', 'categories'));
    }

    public function thanks(Request $request)
    {
        if ($request->input('action') === 'back') {
            return redirect()->route('index')->withInput($request->all());
        }

        if ($request->input('action') === 'submit') {

            Contact::create([
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'tel' => $request->input('tel1') . $request->input('tel2') . $request->input('tel3'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
                'category_id' => $request->input('category_id'),
                'detail' => $request->input('detail'),
            ]);
        }
        return view('thanks');
    }
}
