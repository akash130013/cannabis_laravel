<?php


namespace App\Modules\Admin\Controllers;

use App\AdminDeliveryAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;

class DeliveryAddressImportController extends Controller
{   
    const LIMIT = '10';

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView()
    {
        
        //setup an empty array
        $records = [];

        //path where the csv files are stored
        $folderPath = config('constants.TEMP_IMPORTING_FOLDER_PATH');
                
        $path = public_path() . $folderPath;

        //loop over each file
        foreach (glob($path . '*.csv') as $file) {
            //open the file and add the total number of lines to the records array
            $file = new \SplFileObject($file, 'r');
            $file->seek(PHP_INT_MAX);
            $records[] = $file->key();
        }

        //now sum all the array keys together to get the total
        $toImport = array_sum($records);
        $Records = AdminDeliveryAddress::sortable()->paginate(self::LIMIT);
       
        return view('Admin::import.index', compact('toImport','Records'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        try {
         
            $validator = Validator::make($request->all(), [
                'file' => 'max:5250|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                return Redirect::back()->with('error', ['message' => $validator->errors()->first()]);
            }

            //  Excel::import(new AdminAddressImport, request()->file('file'));

          $updateStatus =  $this->parseImport();

        } catch (Exception $e) {
            
            $http_response_header = [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => trans('Admin::home.upload_valid_file')
            ];

            return Redirect::back()->with('error', $http_response_header);
        }
         
        return Redirect::back()->with('success', $updateStatus);
    }


    /**
     * importLargeDataset
     * @param : request params
     * @return : application/json
     */

    public function parseImport()
    {
        request()->validate([
            'file' => 'required|mimes:csv,txt'
        ]);
        
        //get file from upload
        $path = request()->file('file')->getRealPath();


        $handle = fopen($path, "r");
        $header = fgetcsv($handle, 0, ',');
        $countheader = count($header);
        if (
            ($countheader <= 6)  && in_array('address', $header) && in_array('city', $header) &&
            in_array('state', $header) && in_array('zipcode', $header) && in_array('country', $header)
            && in_array('timezone', $header)
        ) {

           
            //turn into array
            $file = file($path);

            //remove first line
            $data = array_slice($file, 1);

            //loop through file and split every 1000 lines
            $parts = (array_chunk($data, 1000));
            $i = 1;
            foreach ($parts as $line) {
                $folderPath = config('constants.TEMP_IMPORTING_FOLDER_PATH');
                
                if (!file_exists(public_path() . $folderPath)) {
                    mkdir(public_path() . $folderPath);
                }
                $fileName = $folderPath.$i. str_random(5). ".csv";
                $tmpFile = public_path() . "/{$fileName}";
                file_put_contents($tmpFile, $line);
                $i++; 
            }
            return [
                'message' => trans('Admin::home.uploaded_queued'),
                'code'    =>Response::HTTP_OK,
               ];

        } else {
            return [
                "message" =>trans('Admin::home.invalid_header'),
                "code"    =>Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
            ];
        }
    }

    /***
     * To show edit screen
     * @request : location id
     * @return : application/html
     * 
     */
    public function edit($id=null)
    {
        $data='';
        if($id)
        {
            $decryptedId = '';
            try 
            {
              $decryptedId = decrypt($id);
            } 
            catch (DecryptException $e) 
            {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data= AdminDeliveryAddress::find($decryptedId);
        }
        return view('Admin::import.edit',compact('data'));
    }

    /***
     * to update delivery location
     * @request : 
     * @response : application/json
     * 
     */
    public function updateLocation(Request $request)
    {
       $rules = [
           'delivery_location_id'   => 'required|numeric',
           'country'                => 'required',
           'state'                  => 'required',
           'city'                   => 'required',
           'zipcode'                => 'required|numeric',
           'timezone'               => 'required',
       ];
       
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()) 
        {
          return Redirect::back()->with('errors', $validation->errors())->withInput();
        }

        $data = [
            'country'                => request('country'),
            'state'                  => request('state'),
            'city'                   => request('city'),
            'address'                => request('address'),
            // 'zipcode'                => request('zipcode'),
            'timezone'               => request('timezone'),
        ];

        $deliveryLocation = AdminDeliveryAddress::find(request('delivery_location_id'));
        $deliveryLocation->update($data);
        return redirect()->route('admin.show.import')->with(['message' => trans('Admin::messages.product_updated_success'), 'type' => 'success']);

    }
}
