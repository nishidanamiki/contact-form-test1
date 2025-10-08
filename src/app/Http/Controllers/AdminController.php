<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        //検索条件取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date = $request->input('date');

        //問い合わせデータ取得
        $query = Contact::with('category');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")->orWhere('last_name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%")->orWhere(DB::raw("CONCAT(last_name, first_name)"), 'like', "%{$keyword}%");
            });
        }

        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        };

        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }

        //ページネーション
        $contacts = $query->paginate(7);
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories', 'keyword', 'gender', 'category_id', 'date'));
    }

    public function exportCsv(Request $request)
    {
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date = $request->input('date');

        $query = Contact::with('category');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")->orWhere('last_name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%")->orWhere(DB::raw("CONCAT(last_name, first_name)"), 'like', "%{$keyword}%");
            });
        }

        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        };

        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }

        $contacts = $query->get();

        $response = new StreamedResponse(function () use ($contacts) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', '姓', '名', 'メールアドレス', '性別', 'お問い合わせの種類', '作成日']);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    $contact->last_name,
                    $contact->first_name,
                    $contact->email,
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                    optional($contact->category)->content,
                    $contact->created_at->format('Y-m-d'),
                ]);
            }
                fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

        return $response;
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();

        return redirect('/admin');
    }
}
