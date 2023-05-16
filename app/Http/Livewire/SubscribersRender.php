<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Database\QueryException;

class SubscribersRender extends Component
{
    public $newSubscriber = "";
    protected $rules = [
        'newSubscriber' => 'required|email',
    ];
    protected $messages = [
        'newSubscriber.required' => 'El correo electrónico no puede estar vacío.',
        'newSubscriber.email' => 'El correo no tiene un formato valido.',
    ];
    public function render()
    {
        return view('livewire.subscribers-render');
    }

    public function addSubscriber()
    {
        $this->validate();

        try {
            Subscriber::create([
                'email' => $this->newSubscriber,
                'status' => true,
            ]);
            $this->emit('success-auto-close', [
                'message' => 'Gracias por suscribirte. Pronto recibirás noticias referentes a nuevos materiales didácticos.',
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->emit('info', [
                    'message' => 'El correo electrónico ya existe en nuestros registros.',
                ]);
            } else {
                $this->emit('info', [
                    'message' => 'Error al registrar el correo electrónico - ' . $e->getMessage(),
                ]);
            }
        }

        $this->newSubscriber = '';
    }
}
