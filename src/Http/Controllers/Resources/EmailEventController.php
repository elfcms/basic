<?php

namespace Elfcms\Basic\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Basic\Models\EmailAddress;
use Elfcms\Basic\Models\EmailEvent;
use Elfcms\Basic\Models\EmailEventAddress;
use Illuminate\Http\Request;

class EmailEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return EmailEvent::all()->toJson();
        }
        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $events = EmailEvent::orderBy($order, $trend)->paginate(60);

        $events = EmailEvent::all();
        return view('basic::admin.email.events.index',[
            'page' => [
                'title' => 'Email events',
                'current' => url()->current(),
            ],
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = new EmailEvent;
        //dd($el->emailFields);
        $addresses = EmailAddress::all();
        return view('basic::admin.email.events.create',[
            'page' => [
                'title' => 'Create event',
                'current' => url()->current(),
            ],
            'fields' => $event->emailFields,
            'addresses' => $addresses,
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

        $params = [];
        foreach ($request->params_new as $param) {
            if (!empty($param['name'])) {
                $params[$param['name']] = $param['value'];
            }
        }

        $validated = $request->validate([
            'name' => 'required|unique:App\Models\EmailEvent,name',
            'code' => 'required|unique:App\Models\EmailEvent,code',
        ]);

        $validated['description'] = $request->description;
        $validated['subject'] = $request->subject;
        $validated['content'] = $request->content;
        $validated['contentparams'] = $params;

        $event = EmailEvent::create($validated);

        if (!empty($request->from)) {
            EmailEventAddress::create([
                'field' => 'from',
                'email_event_id' => $event->id,
                'email_address_id' => $request->from
            ]);
        }

        if (!empty($request->to)) {
            EmailEventAddress::create([
                'field' => 'to',
                'email_event_id' => $event->id,
                'email_address_id' => $request->to
            ]);
        }

        if (!empty($request->cc)) {
            EmailEventAddress::create([
                'field' => 'cc',
                'email_event_id' => $event->id,
                'email_address_id' => $request->cc
            ]);
        }

        if (!empty($request->bcc)) {
            EmailEventAddress::create([
                'field' => 'bcc',
                'email_event_id' => $event->id,
                'email_address_id' => $request->bcc
            ]);
        }

        if ($request->ajax()) {
            $result = 'error';
            $message = __('basic::elf.error_of_email_event_created');
            $data = [];
            if ($event) {
                $result = 'success';
                $message = __('basic::elf.email_event_created_successfully');
                $data = ['id'=> $event->id];
            }
            return json_encode(['result'=>$result,'message'=>$message,'data'=>$data]);
        }

        return redirect(route('admin.email.events.edit',$event->id))->with('eeventedited',__('basic::elf.email_event_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmailEvent $event, Request $request)
    {
        if ($request->ajax()) {
            return EmailEvent::find($event->id)->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailEvent $event)
    {
        $addresses = EmailAddress::all();

        $params = $event->contentparams ?? [];

        return view('basic::admin.email.events.edit',[
            'page' => [
                'title' => 'Edit email event #' . $event->id,
                'current' => url()->current(),
            ],
            'event' => $event,
            'fields' => $event->fields(),
            'addresses' => $addresses,
            'params' => $params
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailEvent $event)
    {

        $params = [];
        foreach ($request->params_new as $param) {
            if (!empty($param['name'])) {
                $params[$param['name']] = $param['value'];
            }
        }

        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $event->code = $validated['code'];
        $event->name = $validated['name'];
        $event->subject = $request->subject;
        $event->description = $request->description;
        $event->content = $request->content;
        $event->contentparams = $params;

        $existFields = $event->fields();

        //from
        if (empty($existFields['from'])) {
            if (!empty($request->from)) {
                EmailEventAddress::create([
                    'field' => 'from',
                    'email_event_id' => $event->id,
                    'email_address_id' => $request->from
                ]);
            }
        }
        else {
            $eventAddress = EmailEventAddress::where('email_event_id',$event->id)->where('field','from')->first();
            if (empty($request->from)) {
                $eventAddress->delete();
            }
            else {
                $eventAddress->email_address_id = $request->from;
                $eventAddress->save();
            }
        }

        //to
        if (empty($existFields['to'])) {
            if (!empty($request->to)) {
                EmailEventAddress::create([
                    'field' => 'to',
                    'email_event_id' => $event->id,
                    'email_address_id' => $request->to
                ]);
            }
        }
        else {
            $eventAddress = EmailEventAddress::where('email_event_id',$event->id)->where('field','to')->first();
            if (empty($request->to)) {
                $eventAddress->delete();
            }
            else {
                $eventAddress->email_address_id = $request->to;
                $eventAddress->save();
            }
        }

        //cc
        if (empty($existFields['cc'])) {
            if (!empty($request->cc)) {
                EmailEventAddress::create([
                    'field' => 'cc',
                    'email_event_id' => $event->id,
                    'email_address_id' => $request->cc
                ]);
            }
        }
        else {
            $eventAddress = EmailEventAddress::where('email_event_id',$event->id)->where('field','cc')->first();
            if (empty($request->cc)) {
                $eventAddress->delete();
            }
            else {
                $eventAddress->email_address_id = $request->cc;
                $eventAddress->save();
            }
        }

        //bcc
        if (empty($existFields['bcc'])) {
            if (!empty($request->bcc)) {
                EmailEventAddress::create([
                    'field' => 'bcc',
                    'email_event_id' => $event->id,
                    'email_address_id' => $request->bcc
                ]);
            }
        }
        else {
            $eventAddress = EmailEventAddress::where('email_event_id',$event->id)->where('field','bcc')->first();
            if (empty($request->bcc)) {
                $eventAddress->delete();
            }
            else {
                $eventAddress->email_address_id = $request->bcc;
                $eventAddress->save();
            }
        }

        $event->save();

        return redirect(route('admin.email.events.edit',$event->id))->with('eeventedited',__('basic::elf.email_event_created_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailEvent $event)
    {
        if (!$event->delete()) {
            return redirect(route('admin.email.events'))->withErrors(['eeventdelerror'=>'Error of event deleting']);
        }

        return redirect(route('admin.email.events'))->with('eeventdeleted','Event deleted successfully');
    }
}
