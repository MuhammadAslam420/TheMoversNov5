<?php

namespace App\Http\Livewire\Admin\Driver;

use Livewire\Component;
use App\Models\Admin\Driver;
use App\Models\Admin\Zone;
use App\Models\Request\Request as RequestRequest;
use Livewire\WithPagination;

class RequestListComponent extends Component
{
    use WithPagination;
    public $driver;
    public $search;
    public $perPage = 6;
    public $statusFilter = ''; // Filter for completed, cancelled, or not started trips
    public $paymentFilter = ''; // Filter for paid or unpaid trips
    public $paymentMethodFilter = ''; // Filter for payment method (card/online, cash, wallet/cash, wallet)
 public $sorting='desc';
    public function mount($driver)
    {
        $this->driver = $driver->id;
    }


    public function render()
    {

        $results = RequestRequest::where('driver_id', $this->driver)->where('is_paid',$this->paymentFilter)
    ->where(function ($query) {
        $query->where('request_number', 'LIKE', '%' . $this->search . '%')
              ->orWhereDate('created_at', 'LIKE', '%' . $this->search . '%');
    })
    ->orderBy('created_at', $this->sorting)
    ->paginate($this->perPage);



    return view('livewire.admin.driver.request-list-component', ['results' => $results]);
    }
}
