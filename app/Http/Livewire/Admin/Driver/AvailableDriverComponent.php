<?php

namespace App\Http\Livewire\Admin\Driver;

use App\Models\Admin\DriverAvailability;
use Livewire\Component;
use Livewire\WithPagination;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Models\Admin\Driver;

class AvailableDriverComponent extends Component
{
    use WithPagination;
    public $search;
    public $sorting = 'desc';
    public $perPage = 10;
    public function render()
    {
        $query = DriverAvailability::searchByDriverName($this->search);

        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
            $results = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        } else {
            $drivers = Driver::where('zone_id', auth()->user()->admin->zone_id)->pluck('id');
            $results = $query
                ->whereIn('driver_id', $drivers)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        }
    
        return view('livewire.admin.driver.available-driver-component', ['results' => $results]);
    }
}
