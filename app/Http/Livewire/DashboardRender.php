<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardRender extends Component
{
    use WithPagination;
    public  $salesDay, $salesMonth, $salesYear, $salesRange;
    public  $productsDay, $packagesDay, $membershipsDay;
    public $maxProducts = 0, $maxPackages = 0, $maxMemberships = 0;
    public $products, $packages, $memberships;
    public $search = '', $range = '', $range2 = '', $rangeStart, $rangeEnd, $rangeStart2, $rangeEnd2;
    public $sortDirection = 'desc', $sortField = 'created_at';

    public $monthSelect, $monthSelectName, $yearSelect;
    public $sum_day_products;
  
    public  $max_top_products;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['rangeSelect', 'rangeClear'];


    public function mount()
    {
        $fecha = now();
        $day = $fecha->format('Y-m-d');
        $this->monthSelect = $fecha->format('m');
        $this->yearSelect = $fecha->format('Y');


        //Obtener todas las ventas del día (productos, paquetes y membresías)
        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'externo')
            ->sum('amount');

        //obtener la lista de productos vendidos en el día, relacionados con el numero de ventas y la suma de ventas por producto
        $this->productsDay = Product::with(['orders'])
            ->orWhereHas('orders', function ($query) {
                $query->whereBetween('created_at', [now()->format('Y-m-d') . " 00:00:00", now()->format('Y-m-d') . " 23:59:59"]);
            })
            ->withSum('sales', 'price')
            ->withCount('sales')
            ->get();

        //obtener la suma de productos del día

        $this->sum_day_products = Order_Details::join('orders', 'order_details.order_id', 'orders.id')
            ->select('order_details.id')
            ->where('orders.status', 'approved')
            ->where('orders.payment_type', '!=', 'externo')
            ->whereBetween('order_details.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->sum('order_details.price');
    }



    public function render()
    {
        $orders = Order::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('payment_id', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('order_id', 'like', '%' . $this->search . '%')
                    ->orWhere('contacto', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('facebook', 'like', '%' . $this->search . '%')
                    ->orWhere('whatsapp', 'like', '%' . $this->search . '%');
            })->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        $this->salesMonth = Order::whereMonth('created_at', $this->monthSelect)
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'externo')
            ->where(function ($query) {
                $query->whereYear('created_at', '=', $this->yearSelect);
            })
            ->sum('amount');

        $this->salesYear = Order::whereYear('created_at', $this->yearSelect)
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'externo')
            ->sum('amount');
        $this->salesRange = Order::whereBetween('created_at', [$this->rangeStart . " 00:00:01", $this->rangeEnd . " 23:59:59"])
            ->sum('amount');

        $this->setName($this->monthSelect);

        $topProducts = Product::withCount('sales')
            ->withSum('sales', 'price')
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();




        return view('livewire.dashboard-render', compact('orders', 'topProducts'));
    }



    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }

    protected function setName($numeroMes)
    {
        switch ($numeroMes) {
            case 1:
                $this->monthSelectName = "enero";
                break;
            case 2:
                $this->monthSelectName = "febrero";
                break;
            case 3:
                $this->monthSelectName = "marzo";
                break;
            case 4:
                $this->monthSelectName = "abril";
                break;
            case 5:
                $this->monthSelectName = "mayo";
                break;
            case 6:
                $this->monthSelectName = "junio";
                break;
            case 7:
                $this->monthSelectName = "julio";
                break;
            case 8:
                $this->monthSelectName = "agosto";
                break;
            case 9:
                $this->monthSelectName = "septiembre";
                break;
            case 10:
                $this->monthSelectName = "octubre";
                break;
            case 11:
                $this->monthSelectName = "noviembre";
                break;
            case 12:
                $this->monthSelectName = "diciembre";
                break;
            default:

                break;
        }
    }
    public function rangeSelect($value, $value2)
    {
        $this->range = $value;
        $this->range2 = $value2;

        $this->rangeStart = substr($this->range, 0, 10);
        $this->rangeEnd = substr($this->range, 13, 24);
        $this->rangeStart2 = substr($this->range2, 0, 10);
        $this->rangeEnd2 = substr($this->range2, 13, 24);
    }
}
