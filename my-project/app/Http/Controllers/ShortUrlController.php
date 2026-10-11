<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Str;

class ShortUrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('resolve');
    }

    public function index()
    {
        $user = auth()->user();
        $urls = ShortUrl::visibleTo($user)->with(['user','company'])->orderBy('created_at','desc')->get();
        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->isAdmin() || $user->isMember())) {
            abort(403);
        }

        return view('urls.create');
    }

    public function store(ShortUrlRequest $request)
    {
        $user = auth()->user();
        if (! ($user->isAdmin() || $user->isMember())) {
            abort(403);
        }

        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code',$code)->exists());

        $url = ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $code,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);

        return redirect()->route('urls.index')->with('status','Short URL created');
    }

    // Public resolver
    public function resolve($code)
    {
        $url = ShortUrl::where('short_code',$code)->firstOrFail();
        return redirect()->away($url->original_url);
    }
}
