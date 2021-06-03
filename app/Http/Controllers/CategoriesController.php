<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
     * Show the Category Index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if(isset($data['search']))
            $department_list = Category::where('name', 'like', '%'. $data['search']. '%')->paginate();
        else
            $department_list = Category::paginate();

        return view('category.index', [
            'categories_list' => $categories_list ?? [],
        ]);
    }

    /**
     * Redirect to Register Category page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register()
    {
        return view('category.register');
    }

    /**
     * Create new Category on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $auth_id = auth()->user()->id;

        if($data){
            $category = Category::create(['name' => $data['name'], 'user_id' => $auth_id]);
            $array_response  = [
                'name' => $category->name ?? null,
            ];
        }
        else {
            $array_response  = [
                'error' => true,
            ];
        }

        json_encode($array_response);
    }

     /**
     * edit page Category on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);

        return view('category.edit', [
            'category' => $category ?? null,
        ]);
    }

    /**
     * Update Category on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $category_id)
    {
        $data = $request->all();

        $category = Category::findOrFail($category_id);
        $category->update($data);

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('category.index');
    }

    /**
     * Delete Category on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
