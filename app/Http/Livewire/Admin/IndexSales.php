<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use App\Models\Order_Details;
use App\Mail\MembresiaPrimaria;
use App\Mail\MembresiaPreescolar;
use App\Mail\PaymentApprovedEmail;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;

class IndexSales extends Component
{
    use WithPagination;
    public $search = '';
    public $order;

    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $orders = Order::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('payment_id', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('order_id', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        return view('livewire.admin.index-sales', compact('orders'));
    }

    //actualizar orden desde mercado pago
    public function updateStatus($id)
    {
        $response = Http::get("https://api.mercadopago.com/v1/payments/$id" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");

        $response = json_decode($response);
        $newStatus = $response->status;
        try {
            Order::where('payment_id', $id)
                ->firstOrFail()
                ->update([
                    'status' => $newStatus,
                ]);

            $this->emit('success-auto-close', [
                'message' => 'El pago se actualizó con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'error' => 'Ocurrio un error al actualizar el pago.',
            ]);
        }
    }

    //sort
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

    public function deleteOrder($id)
    {

        try {

            Order::destroy($id);

            $this->emit('deleteSuccess', $id);
        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                $messageError = 'La orden tene uno o mas productos asignados.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->emit('error', [
                'message' => 'Error al eliminar el registro - ' . $messageError,
            ]);
        }
    }

    public function resendOrder($order)
    {
        $materialesComprados = false;
        $MembresiasCompradas = [];

        $this->order = Order::findOrFail($order);

        


        $productosOrder = Order_Details::where('order_id', $this->order->id)->get();
        $customer =User::findOrFail ($this->order->customer_id);

     

        
       

        foreach ($productosOrder as $item) {
            if ($item->membership_id != null) {
                
            
                $membresia = Membership::findOrFail($item->membership_id);
       
                $MembresiasCompradas[] = [
                    'membership_id' => $membresia->id,
                    'title' => $membresia->title,
                    'price' => $item->price,
                ];
            } elseif ($item->package_id != null || $item->product_id != null) {

                $materialesComprados = true;
            }
        }



        //enviar correo de materiales
        if ($materialesComprados) {
            $correo = new PaymentApprovedEmail($this->order->id, $customer->name,  $this->order->amount);
            Mail::to($customer->email)
                ->send($correo);

            $correoCopia = new PaymentApprovedEmail($this->order->id, $customer->name, $this->order->amount);
            Mail::to('arnulfoacosta0887@gmail.com')
                ->send($correoCopia);
                $this->emit('success-auto-close', [
                    'message' => 'Orden enviada',
                ]);
        }

        //enviar correo de membresias
        foreach ($MembresiasCompradas as $membresia) {

            //validar si es membresia preescolar, se tiene que cambiar cada año
            if ($membresia['membership_id'] == 2006) {

                $correo = new MembresiaPreescolar($this->order->id, $customer->name,$customer->email, $membresia['price']);
                Mail::to($customer->email)
                    ->send($correo);
                $correoCopia = new MembresiaPreescolar($this->order->id, $customer->name, $customer->email, $membresia['price']);
                Mail::to('arnulfoacosta0887@gmail.com')
                    ->send($correoCopia);
                    $this->emit('success-auto-close', [
                        'message' => 'Preescolar enviada',
                    ]);
            }

            if ($membresia['membership_id'] == 2007) {
                $correo = new MembresiaPrimaria($this->order->id, $customer->name, $customer->email, $membresia['price']);
                Mail::to($customer->email)
                    ->send($correo);
                $correoCopia = new MembresiaPrimaria($this->order->id, $customer->name, $customer->email, $membresia['price']);
                Mail::to('arnulfoacosta0887@gmail.com')
                    ->send($correoCopia);
                    $this->emit('success-auto-close', [
                        'message' => 'Primaria enviada',
                    ]);
            }
        }
    }
}
