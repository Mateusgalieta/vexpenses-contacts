<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
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
            $department_list = Department::where('name', 'like', '%'. $data['search']. '%')->paginate();
        else
            $department_list = Department::paginate();

        return view('department.index', [
            'department_list' => $department_list ?? [],
        ]);
    }

    /**
     * Redirect to Add department page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register()
    {
        return view('department.register');
    }

    /**
     * Create new Department on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $request->all();

        Department::create($data);

        session()->flash('alert-success', 'Criado com sucesso!');
        return redirect()->back();
    }

     /**
     * edit page Department on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($department_id)
    {
        $department = Department::findOrFail($department_id);

        return view('department.edit', [
            'department' => $department ?? null,
        ]);
    }

    /**
     * Update Department on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $department_id)
    {
        $data = $request->all();

        $department = Department::findOrFail($department_id);
        $department->update($data);

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('department.index');
    }

    /**
     * Delete Department on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($department_id)
    {
        $department = Department::findOrFail($department_id);
        $department->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
