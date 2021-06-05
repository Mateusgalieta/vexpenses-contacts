<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
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
     * Show the Contact Index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if(isset($data['search']))
            $contacts_list = Contact::where('name', 'like', '%'. $data['search']. '%')->paginate();
        else
            $contacts_list = Contact::paginate();

        return view('contact.index', [
            'contacts_list' => $contacts_list ?? [],
        ]);
    }

    /**
     * Redirect to Register Contact page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register()
    {
        return view('contact.register');
    }

    /**
     * Create new Contact on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $auth_id = auth()->user()->id;

        if($data){
            $contact = Contact::create(['name' => $data['name'], 'user_id' => $auth_id]);
            $response = [
                'status' => 'success',
                'message' => "Criado com sucesso!",
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => "Ocorreu um erro. Por favor, tente novamente!",
            ];
        }

        return $response;
    }

     /**
     * edit page Contact on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);

        return view('contact.edit', [
            'contact' => $contact ?? null,
        ]);
    }

    /**
     * Update Contact on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $contact_id)
    {
        $data = $request->all();

        $contact = Contact::findOrFail($contact_id);
        $contact->update($data);

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('contact.index');
    }

    /**
     * Delete Contact on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($contact_id)
    {
        $category = Category::findOrFail($contact_id);
        $category->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
