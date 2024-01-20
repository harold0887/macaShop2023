<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use App\Models\Order_Details;

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
    public $sum_day_products, $sum_day_packages;

    public  $topProducts;
    public $day;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['rangeSelect', 'rangeClear'];





    public function mount()
    {
        $fecha = now();
        $this->day = $fecha->format('Y-m-d');
        $this->monthSelect = $fecha->format('m');
        $this->yearSelect = $fecha->format('Y');
    }




    public function render()
    {
        $day = $this->day;

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
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'externo')
            ->sum('amount');

        $this->setName($this->monthSelect);




        //Obtener todas las ventas del día (productos, paquetes y membresías)
        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'externo')
            ->sum('amount');


        //Obtener todas las ventas de productos del día con el numero de ventas y la suma de ventas de cada producto
        $this->productsDay = Product::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                ->where('status', 'approved')
                ->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();


        //Obtener todas las ventas de paquetes del día con el numero de ventas y la suma de ventas de cada producto
        $this->packagesDay = Package::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                ->where('status', 'approved')
                ->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();

        //Obtener todas las ventas de membresías del día con el numero de ventas y la suma de ventas de cada producto
        $this->membershipsDay = Membership::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                ->where('status', 'approved')
                ->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                    ->whereHas('order', function ($query) use ($day) {
                        $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
                            ->where('status', 'approved')
                            ->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();

        $this->topProducts = Product::withCount(['sales' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved')
                    ->where('payment_type', '!=', 'externo');
            });
        }])
            ->withSum(['sales' => function ($query) {
                $query->whereHas('order', function ($query) {
                    $query
                        ->where('status', 'approved')
                        ->where('payment_type', '!=', 'externo');
                });
            }], 'price')
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();






        return view('livewire.dashboard-render', compact('orders'));
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
