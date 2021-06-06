<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
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
        $categories_list = Category::where('user_id', auth()->user()->id)->get();
        return view('contact.register', [
            'categories_list' => $categories_list ?? [],
        ]);
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
            'category_id' => 'required',
        ]);
        $auth_id = auth()->user()->id;

        $data = $request->all();

        if($request->hasFile('avatar_url')){
            // Get filename with the extension
            $filenameWithExt = $request->file('avatar_url')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('avatar_url')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('avatar_url')->storeAs('img', $fileNameToStore);
        }

        if($data){
            $contact = Contact::create(['avatar_url' => $path ?? null, 'name' => $data['name'], 'created_by' => $auth_id, 'category_id' => $data['category_id']]);
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

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('contact.index');
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

        if($request->hasFile('avatar_url')){
            // Get filename with the extension
            $filenameWithExt = $request->file('avatar_url')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('avatar_url')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('avatar_url')->storeAs('public/img', $fileNameToStore);

            $data['avatar_url'] = $path;
        }

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
        $contact = Contact::findOrFail($contact_id);
        $contact->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
