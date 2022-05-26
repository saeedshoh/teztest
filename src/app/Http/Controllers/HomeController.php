<?php namespace App\Http\Controllers;


use App\Modules\Orders\Repositories\OrderRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('auth');
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $orders = $this->orderRepository->getAll($request);
        $getFilters = $this->orderRepository->getOrderFilters();

        return view('order.index', ['orders' => $orders, 'filters' => $getFilters]);
    }
}
