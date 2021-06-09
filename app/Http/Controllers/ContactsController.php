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
        $auth_id = auth()->user()->id;

        if(isset($data['search']))
            $contacts_list = Contact::where('created_by', $auth_id)->where('name', 'like', '%'. $data['search']. '%')->paginate();
        else
            $contacts_list = Contact::where('created_by', $auth_id)->paginate();

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

            session()->flash('alert-success', 'Atualizado com sucesso!');
            return redirect()->route('contact.index');
        }

        session()->flash('alert-danger', 'Ocorreu um erro');
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
            $contact = Contact::findOrFail($contact_id);
            $contact = Contact::update(['avatar_url' => $path ?? null, 'name' => $data['name'], 'created_by' => $auth_id, 'category_id' => $data['category_id']]);

            session()->flash('alert-success', 'Atualizado com sucesso!');
            return redirect()->route('contact.index');
        }

        session()->flash('alert-danger', 'Ocorreu um erro');
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
        $contact->phones()->delete();
        $contact->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

    /**
     * Redirect to Import Contact Page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function import()
    {
        $categories_list = Category::where('user_id', auth()->user()->id)->get();
        return view('contact.import', [
            'categories_list' => $categories_list ?? [],
        ]);
    }

    /**
     * Method to import Process
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function importProcess(Request $request)
    {
        $data = $request->all();
        $auth_id = auth()->user()->id;

        $request->validate([
            'category_id' => 'required',
            'token'       => 'required',
        ]);

        if($data){
            $ch = curl_init();

            $url_endpoint = 'https://dev.api.vexpenses.com/v2/team-members';

            curl_setopt($ch, CURLOPT_URL, $url_endpoint);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Authorization' => $data['token']
            ));

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

            if($data['code'] == 200){
                foreach($response['data'] as $row_contact){
                    $new_contact = Contact::create([
                        'name' => $row_contact['name'],
                        'created_by' => $auth_id,
                        'category_id' => $data['category_id'],
                    ]);

                    $new_phone = Phone::create([
                        'phone' => $row_contact['phone1'],
                        'contact_id' => $new_contact->id,
                        'type'  => '2',//Celular (De acordo com a documentação da API)
                    ]);
                }
            }

            session()->flash('alert-success', 'Importado com sucesso!');
            return redirect()->back();
        } else {
            session()->flash('alert-success', 'Ocorreu um erro na importação!');
            return redirect()->back();
        }
    }

}
