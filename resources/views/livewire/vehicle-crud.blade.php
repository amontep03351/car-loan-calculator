<div class="container mt-4">
    <div class="row">
        <!-- Form Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $updateMode ? 'Edit Vehicle' : 'Add Vehicle' }}</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" id="type" wire:model="type" class="form-control">
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" id="brand" wire:model="brand" class="form-control">
                            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" id="model" wire:model="model" class="form-control">
                            @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" id="color" wire:model="color" class="form-control">
                            @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $updateMode ? 'Update' : 'Create' }}</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-md-8">
            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="alert alert-success mt-3">{{ session('message') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Vehicle List</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Color</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->type }}</td>
                                    <td>{{ $vehicle->brand }}</td>
                                    <td>{{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->color }}</td>
                                    <td>
                                        <button wire:click="edit({{ $vehicle->id }})" class="btn btn-warning btn-sm">Edit</button>
                                        <button wire:click="delete({{ $vehicle->id }})" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
