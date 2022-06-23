<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Address as AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = QueryBuilder::for(Address::class)
        ->allowedFilters('address', 'postcode', 'city')
        ->allowedSorts('address', 'postcode')
        ->get();

        if($addresses->isempty()) {
            return $this->sendError('There is no users based on your filter');
        }

        return $this->sendResponse(AddressResource::collection($addresses), 'All addresses retrieved.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'postcode' => 'required|regex:/^(([1-95]{2}|2A|2B)[0-9]{3})$|^[971-974]$/',
            'city' => 'required|string|max:255',
            'lon' => 'required|numeric',
            'lat' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect address or missing parameters', $validator->errors());
        }

        $input = $request->all();

        $address = Address::create($input);

        return $this->sendResponse($address, 'Address created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
        
        return $this->sendResponse(new AddressResource($address), 'Address retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
 
        if(Auth::guard('sanctum_user')->id() !== $address->user_id) { 
            return $this->sendError('You are not allowed to update this address', [], 403); // 403 forbidden
        }

        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'postcode' => 'required|regex:/^(([1-95]{2}|2A|2B)[0-9]{3})$|^[971-974]$/', // regex for postcode in France
            'city' => 'required|string|max:255',
            'lon' => 'required|numeric',
            'lat' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Incorrect address or missing parameters', $validator->errors());
        }

        $input = $request->all();
        
        $address->update($input);

        return $this->sendResponse($address, 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return $this->sendError('The address does not exist.');
        }
        
        if($address->user_id != Auth::guard('sanctum_user')->id()) { // if the address id is not the same as the authenticated user id, return an error
            return $this->sendError('You are not authorized to delete this address.', [], 403); // 403 forbidden
        }
        
        return $this->sendResponse([], 'Address deleted.');
    }
}
