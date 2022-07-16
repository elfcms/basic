<?php

namespace Elfcms\Basic\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Basic\Models\EmailAddress;
use Illuminate\Http\Request;

class EmailAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return EmailAddress::all()->toJson();
        }
        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $addresses = EmailAddress::orderBy($order, $trend)->paginate(30);
        //$addresses = EmailAddress::all();
        return view('basic::admin.email.addresses.index',[
            'page' => [
                'title' => 'Email addresses',
                'current' => url()->current(),
            ],
            'addresses' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic::admin.email.addresses.create',[
            'page' => [
                'title' => 'Create address',
                'current' => url()->current(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $validated = $request->validate([
            'name' => 'required|unique:App\Models\EmailAddress,name',
            'email' => 'required|unique:App\Models\EmailAddress,email'
        ]);
        //dd($request->description);
        $validated['description'] = $request->description;
        //dd($validated);
        $address = EmailAddress::create($validated);

        if ($request->ajax()) {
            $result = 'error';
            $message = __('basic::elf.error_of_email_address_created');
            $data = [];
            if ($address) {
                $result = 'success';
                $message = __('basic::elf.email_address_created_successfully');
                $data = ['id'=> $address->id];
            }
            return json_encode(['result'=>$result,'message'=>$message,'data'=>$data]);
        }

        return redirect(route('admin.email.addresses.edit',$address->id))->with('eaddredited',__('basic::elf.email_address_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmailAddress $address, Request $request)
    {
        if ($request->ajax()) {
            return EmailAddress::find($address->id)->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailAddress $address)
    {
        //dd($address);
        return view('basic::admin.email.addresses.edit',[
            'page' => [
                'title' => 'Edit email address #' . $address->id,
                'current' => url()->current(),
            ],
            'address' => $address
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailAddress $address)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $address->name = $validated['name'];
        $address->email = $validated['email'];
        $address->description = $request->description;

        $address->save();

        return redirect(route('admin.email.addresses.edit',$address->id))->with('eaddredited',__('basic::elf.email_address_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailAddress $address)
    {
        if (!$address->delete()) {
            return redirect(route('admin.email.addresses'))->withErrors(['eaddrdelerror'=>'Error of address deleting']);
        }

        return redirect(route('admin.email.addresses'))->with('eaddrdeleted','Address deleted successfully');
    }
}
