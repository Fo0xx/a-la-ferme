<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Farm as FarmCollection;
use App\Models\Farm;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FarmController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farms = QueryBuilder::for(Farm::class)
            ->allowedIncludes(['address', 'user', 'category', 'votes'])
            ->allowedFilters('name', AllowedFilter::exact('address.postcode'), AllowedFilter::exact('address.city'))
            ->allowedSorts('name')
            ->paginate(20);

        if ($farms->isempty()) {
            return $this->sendError('There is no farms based on your filters.');
        }

        return $this->sendResponse(FarmCollection::collection($farms), 'All farms retrieved.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'farm_image' => 'required|image:jpeg,png,jpg|max:2048',
            'address_id' => 'required|integer',
            'farm_details_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect farm or missing parameters.', $validator->errors(), 400);
        }

        // If the adressed is not in the database or the user_id is not in the database, return an error
        if(!Address::find($input['address_id']) || !User::find($input['user_id'])) {
            return $this->sendError('The address or the user does not exist.', [], 404); // 404 Not Found error
        }

        if ($request->hasFile('farm_image')) {
            $uploadFolder = 'mafermelocale/images/farms/' . date('Y') . '/' . date('m');
            $image = $request->file('farm_image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');

            // Create the farm and save it in the database
            $input = $request->all();
            $input['farm_image'] = Storage::url($image_uploaded_path);
        }

        $farm = Farm::create($input);

        return $this->sendResponse($farm, 'Farm created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('The farm does not exist.');
        }

        $farmQuery = QueryBuilder::for(Farm::class)
            ->allowedIncludes(['votes', 'farm_detail', 'address', 'user', 'products'])
            ->where('id', $id)
            ->first();

        return $this->sendResponse($farmQuery, 'Farm retrieved.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('The farm does not exist.');
        }

        $input = $request->all();

        //if there is a new image, delete the old one and save the new one
        if ($request->hasFile('farm_image')) {
            //get the farm image path and delete the image from storage
            $farm_image = $farm->farm_image; // get the image path from the farm object 
            Storage::delete($farm_image); // delete the image from storage 

            // upload the new image 
            $uploadFolder = 'mafermelocale/images/farms/' . date('Y') . '/' . date('m');
            $image = $request->file('farm_image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');

            /**
             * Update the farm object with the new image path
             */
            $input['farm_image'] = Storage::url($image_uploaded_path);
        }

        $farm->update($input);

        return $this->sendResponse($farm, 'Farm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $farm = Farm::find($id);

        if (is_null($farm)) {
            return $this->sendError('The farm does not exist.');
        }

        if (!$this->checkUser($farm->user_id)) {
            return $this->sendError('You are not the owner of this farm.', [], 403);
        }

        $farm->delete();

        // Get the farm image path and delete the image from storage
        $farm_image = $farm->farm_image; // Get the image path from the category object 
        Storage::delete($farm_image); // Delete the image from storage 

        return $this->sendResponse([], 'Farm deleted.');
    }

    /**
     * Get all farms within a given radius.
     * 
     * @param  double $longitude
     * @param  double $latitude
     * @param  int $radius
     * 
     * @return \Illuminate\Http\Response
     * 
     */
    public function getFarmsByRadius($longitude, $latitude, $radius)
    {
        if (empty($longitude) || empty($latitude) || empty($radius) || !is_numeric($longitude) || !is_numeric($latitude) || !is_numeric($radius)) {
            return $this->sendError('The given parameters are not valid.');
        }

        // 6371 is the radius of the Earth in km
        $farms = Address::selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        $farms = QueryBuilder::for(Farm::with('farm_detail')->whereIn('address_id', $farms->pluck('id'))) // Get farms with the same address id as the address with the given radius
            ->allowedFilters('name') // Filter by name, postcode and city
            ->allowedSorts('name') // Sort by name, postcode and city
            ->paginate(20); // Paginate 20 results

        if ($farms->isempty()) {
            return $this->sendError('There is no farms based on your filters');
        }

        return $this->sendResponse($farms, 'All farms retrieved.');
    }
}
