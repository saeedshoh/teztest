<?php namespace App\Http\Controllers\Admin\Orders;


use App\Http\Controllers\Controller;
use App\Modules\Common\Models\City;
use App\Modules\Orders\Models\DeliveryAgency;
use App\Modules\Orders\Requests\DeliveryAgencyRequest;
use App\Modules\Orders\UseCases\DeliveryAgencyCrud;
use App\Modules\Users\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DeliveryAgencyController extends Controller
{

    private $deliveryAgencyCrud;

    public function __construct(DeliveryAgencyCrud $deliveryAgencyCrud)
    {
        $this->deliveryAgencyCrud = $deliveryAgencyCrud;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $deliveryAgencies = DeliveryAgency::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('phone_number', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $deliveryAgencies = DeliveryAgency::latest()->paginate($perPage)->withQueryString();
        }

        return view('delivery-agency.index', ['deliveryAgencies' => $deliveryAgencies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $cities = City::get()->pluck('name', 'id')->toArray();
        return view('delivery-agency.create', ['cities' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryAgencyRequest $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(DeliveryAgencyRequest $request)
    {
        $agencyArray = $request->except('email', 'password');
        $userArray = $request->only('name', 'email', 'password');

        $agency = $this->deliveryAgencyCrud->create($agencyArray, $userArray);

        flash()->success('Новая служба доставки успешно добавлено');

        return redirect('delivery_agencies/'. $agency->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function show($id)
    {
        $deliveryAgency = DeliveryAgency::findOrFail($id);

        return view('delivery-agency.show', ['deliveryAgency' => $deliveryAgency]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function edit($id)
    {
        $deliveryAgency = DeliveryAgency::findOrFail($id);
        $cities = City::get()->pluck('name', 'id')->toArray();

        return view('delivery-agency.edit', ['deliveryAgency' => $deliveryAgency, 'cities' => $cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $deliveryAgency = DeliveryAgency::findOrFail($id);
        $deliveryAgency->update($requestData);

        User::where('id', $deliveryAgency->user_id)->update(['status' => $request->status]);

        flash()->success('Служба доставки успешно изменен');

        return redirect('delivery_agencies/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        \DB::transaction(function () use ($id) {
            $agency = DeliveryAgency::find($id);
            User::destroy($agency->user_id);
            $agency->delete();
        });

        flash()->success('Служба доставки успешно удален');
        return redirect('delivery_agencies/');
    }
}
