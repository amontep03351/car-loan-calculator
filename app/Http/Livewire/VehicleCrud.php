<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehicle;

class VehicleCrud extends Component
{
    use WithPagination;

    public $type, $brand, $model, $color, $vehicleId;
    public $updateMode = false;

    public function render()
    {
        return view('livewire.vehicle-crud', [
            'vehicles' => Vehicle::paginate(10),
        ]);
        
    }

    public function store()
    {
        $this->validate([
            'type' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
        ]);

        Vehicle::updateOrCreate(['id' => $this->vehicleId], [
            'type' => $this->type,
            'brand' => $this->brand,
            'model' => $this->model,
            'color' => $this->color,
        ]);

        session()->flash('message', $this->vehicleId ? 'Vehicle updated successfully.' : 'Vehicle created successfully.');

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->vehicleId = $id;
        $this->type = $vehicle->type;
        $this->brand = $vehicle->brand;
        $this->model = $vehicle->model;
        $this->color = $vehicle->color;

        $this->updateMode = true;
    }

    public function delete($id)
    {
        Vehicle::find($id)->delete();
        session()->flash('message', 'Vehicle deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->type = '';
        $this->brand = '';
        $this->model = '';
        $this->color = '';
        $this->vehicleId = null;
        $this->updateMode = false;
    }
}