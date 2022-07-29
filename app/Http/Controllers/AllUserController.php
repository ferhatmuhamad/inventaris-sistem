<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class AllUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('read-dashboard')) {
            return view('pages.alluser.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-all-profile')) {
            $user = Auth::user()->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->select('users.id', 'roles.name','users.nama','users.email')
            ->get();

            return Datatables::of($user)
            ->addIndexColumn()
            ->addColumn('id_user', function ($user) {
                $id_user = $user->id;

                return $id_user;
            })
            ->addColumn('nama_user', function ($user) {
                $nama_user = $user->nama;

                return $nama_user;
            })
            ->addColumn('email_user', function ($user) {
                $email_user = $user->email;

                return $email_user;
            })
            ->addColumn('role_user', function ($user) {
                $role_user = $user->name;

                return $role_user;
            })
            ->addColumn('status', function ($user) {
                $status = '<span class="badge badge-'.( $user->name == 'user' ? 'danger' : 'primary' ).'">'.( $user->name == 'user' ? 'BUTUH VERIFIKASI!' : 'SELESAI VERIFIKASI' ).'</span>';

                return $status;
            })
            ->addColumn('action', function ($user){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['delete-all-profile'])) {
                    $btn .= '<a id="delete-btn" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$user->id.'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                } else {
                    $btn = '<a id="none-btn" href="/forbidden" class="btn btn-danger btn-sm" title="'.__('general.none').'" data-toggle="tooltip" data-placement="left"></i>Tidak Tersedia</a> ';
                }
                $btn .= '</div></div>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete-all-profile')) {
            $id = Auth::user()->findOrFail($id);
            // dd($id);
            if ($id != null) {
                $id->delete();
            }

            return redirect('dashboard')->with('success', 'User Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
