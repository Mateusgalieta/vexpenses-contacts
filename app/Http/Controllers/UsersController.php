<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if(isset($data['search']))
            $users_list = User::where('name', 'like', '%'. $data['search']. '%')->where('id', '!=', auth()->user()->id)->paginate();
        else
            $users_list = User::where('id', '!=', auth()->user()->id)->paginate();

        return view('user.index', [
            'users_list' => $users_list ?? [],
        ]);
    }

    /**
     * Redirect to Add department page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register()
    {
        $department_list = Department::all();
        return view('user.register', [
            'department_list' => $department_list->pluck('name', 'id')->toArray() ?? [],
        ]);
    }

    /**
     * Create new User on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $request->all();

        User::create($data);

        session()->flash('alert-success', 'Criado com sucesso!');
        return redirect()->route('user.index');
    }

     /**
     * edit page User on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        $department_list = Department::all();

        return view('user.edit', [
            'user' => $user ?? null,
            'department_list' => $department_list->pluck('name', 'id')->toArray() ?? [],
        ]);
    }

    /**
     * Update User on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $user_id)
    {
        $data = $request->all();
        $user = User::findOrFail($user_id);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = bcrypt($user->password);
        }

        $user->update($data);

        activity()->log('Atualizado cliente pelo usuário');

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('user.index');
    }

    /**
     * Delete User on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
