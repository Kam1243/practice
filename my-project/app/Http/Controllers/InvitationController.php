<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteCreateRequest;
use App\Http\Requests\AcceptInvitationRequest;
use App\Models\Invitation;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show create form and list pending invites
    public function create()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $invitations = Invitation::whereNull('accepted_at')->get();
            $roles = Role::all();
            return view('invitations.create', compact('invitations','roles'));
        }

        abort(403);
    }

    public function store(InviteCreateRequest $request)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            // create a new company and invite an Admin
            $company = Company::create(['name' => $request->input('company_name')]);
            $role = Role::where('name','Admin')->first();
            $invite = Invitation::create([
                'email' => $request->email,
                'name' => $request->name,
                'role_id' => $role->id,
                'company_id' => $company->id,
                'invited_by' => $user->id,
                'token' => Str::random(40),
            ]);
        } elseif ($user->isAdmin()) {
            $role = Role::findOrFail($request->role_id);
            if (! in_array($role->name, ['Admin','Member'])) {
                abort(403);
            }

            $invite = Invitation::create([
                'email' => $request->email,
                'name' => $request->name,
                'role_id' => $role->id,
                'company_id' => $user->company_id,
                'invited_by' => $user->id,
                'token' => Str::random(40),
            ]);
        } else {
            abort(403);
        }

        $link = url('/invitation/accept/'.$invite->token);
        Log::info('Invitation created: '.$link);

        return view('invitations.created', compact('invite','link'));
    }

    public function accept(Request $request, $token)
    {
        $inv = Invitation::where('token',$token)->firstOrFail();
        if ($inv->accepted_at) {
            abort(400,'Already accepted');
        }

        return view('invitations.accept', compact('inv'));
    }

    public function processAccept(AcceptInvitationRequest $request, $token)
    {
        $inv = Invitation::where('token',$token)->firstOrFail();
        if ($inv->accepted_at) {
            abort(400,'Already accepted');
        }

        $user = User::create([
            'name' => $inv->name,
            'email' => $inv->email,
            'password' => $request->password,
            'role_id' => $inv->role_id,
            'company_id' => $inv->company_id,
        ]);

        $inv->accepted_at = now();
        $inv->save();

        auth()->login($user);

        return redirect('/dashboard');
    }
}
