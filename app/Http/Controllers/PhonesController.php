<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;

class PhonesController extends Controller
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
     * Show the Phone Index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $contact_id)
    {
        $data = $request->all();
        if(isset($data['search']))
            $phones_list = Phone::where('contact_id', $contact_id)->where('phone', 'like', '%'. $data['search']. '%')->paginate();
        else
            $phones_list = Phone::where('contact_id', $contact_id)->paginate();

        return view('contact.phone.index', [
            'phones_list' => $phones_list ?? [],
        ]);
    }

    /**
     * Redirect to Register Phone page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register($contact_id)
    {
        return view('contact.phone.register');
    }

    /**
     * Create new Phone on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request, $contact_id)
    {
        $data = $request->validate([
            'phone' => 'required|string',
            'type'  => 'required|integer',
        ]);

        if($data){
            $Phone = Phone::create([
                'type' => $data['type'],
                'phone' => $data['phone'],
                'contact_id' => $contact_id
            ]);
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
     * edit page Phone on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($contact_id, $phone_id)
    {
        $phone = Phone::findOrFail($phone_id);

        return view('contact.phone.edit', [
            'phone' => $phone ?? null,
        ]);
    }

    /**
     * Update Phone on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $contact_id, $phone_id)
    {
        $data = $request->all();

        $phone = Phone::findOrFail($phone_id);
        $phone->update($data);

        session()->flash('alert-success', 'Atualizado com sucesso!');
        return redirect()->route('phone.index', $contact_id);
    }

    /**
     * Delete Phone on the System
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($contact_id, $phone_id)
    {
        $phone = Phone::findOrFail($phone_id);
        $phone->delete();

        session()->flash('alert-success', 'Deletado com sucesso!');
        return redirect()->back();
    }

}
