<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Course\Transformers\Dashboard\OrderResource;
use Modules\Course\Repositories\Dashboard\OrderRepository as Order;

class OrderController extends Controller
{
    function __construct(Order $order)
    {
        $this->order     = $order;
    }

    public function index()
    {
        return view('course::dashboard.order.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $order = $this->order->findById($id);

        return view('course::dashboard.order.show' , compact('order') );
    }

    public function order($courseId,$userId)
    {
        $order = $this->order->findOrderByCourseId($courseId,$userId);

        if (is_null($order))
            abort(404);

        return view('course::dashboard.order.order' , compact('order') );
    }

}
