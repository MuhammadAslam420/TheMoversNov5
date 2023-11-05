<?php

namespace App\Http\Controllers\Web\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeatPrice;
use Illuminate\Support\Facades\Storage;

class SeatPriceController extends Controller
{   
    public function index()
    {
        
        $seatPrices = SeatPrice::all();
        $page = trans('pages_names.roles');

        $main_menu = 'settings';

        $sub_menu = 'roles';
        return view('admin.master.seat_price.index', compact('seatPrices', 'page', 'main_menu', 'sub_menu'));
    }

    public function create()
    {
        $seatPrices = SeatPrice::all();
        $page = trans('pages_names.roles');

        $main_menu = 'settings';

        $sub_menu = 'roles';
        return view('admin.master.seat_price.create', compact('page', 'main_menu', 'sub_menu'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'front_seat' => 'required',
            'back_left' => 'required',
            'back_right' => 'required',
            'back_center' => 'required',
            'pick_city' => 'required',
            'drop_city' => 'required',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric',
            'vehicle_type' => 'required',
            'vehicle_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       
        $filePath = 'seat_price_image';

        if ($request->hasFile('vehicle_image')) {
            $imageFile = $request->file('vehicle_image');
            $imagePath = Storage::put($filePath, $imageFile);
            $data['vehicle_image'] = $imagePath;
        }
        SeatPrice::create($data);

        return redirect()->route('seat_price.index')
            ->with('success', 'Seat price added successfully.');
    }
    

    public function edit(SeatPrice $seatPrice)
    {
        $page = trans('pages_names.roles');

        $main_menu = 'settings';

        $sub_menu = 'roles';
        return view('admin.master.seat_price.edit', compact('seatPrice','page', 'main_menu', 'sub_menu'));
        
    }

    public function update(Request $request, SeatPrice $seatPrice)
    {
        $data = $request->validate([
            'front_seat' => 'required',
            'back_left' => 'required',
            'back_right' => 'required',
            'back_center' => 'required',
            'pick_city' => 'required',
            'drop_city' => 'required',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric',
            'vehicle_type' => 'required',
            'vehicle_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // if ($request->hasFile('vehicle_image')) {
        //     $imagePath = $request->file('vehicle_image')->store('seat_price_images', 'public');
        //     $data['vehicle_image'] = $imagePath;
        // }
        $filePath = 'seat_price_image';

if ($request->hasFile('vehicle_image')) {
    $imageFile = $request->file('vehicle_image');
    $imagePath = Storage::put($filePath, $imageFile);
    $data['vehicle_image'] = $imagePath;
}
    
$seatPrice->update($data);

        return redirect()->route('seat_price.index')
            ->with('success', 'Seat price updated successfully.');
    }

    public function destroy(SeatPrice $seatPrice)
    {
        $seatPrice->delete();

        return redirect()->route('seat_price.index')
            ->with('success', 'Seat price deleted successfully.');
    }
}