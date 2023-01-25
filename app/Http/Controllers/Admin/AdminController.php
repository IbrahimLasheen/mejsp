<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admins;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public $path = "admin-assets/uploads/admins/";



    // Display All Admins Page
    public function all_admin()
    {
        if (getAuth('admin', 'role') != 'administrator') {
            return redirect(adminUrl(""));
        }
        $admins = Admins::orderBy("id", 'DESC')->get();
        return view("admin.managers.all", compact("admins"));
    }

    // Display All Admins Page
    public function create()
    {
        if (getAuth('admin', 'role') != 'administrator') {
            return redirect(adminUrl(""));
        }
        return view("admin.managers.add");
    }


    // Add New Row In DB
    public function store(Request $request)
    {
        if (getAuth('admin', 'role') == 'administrator') {

            // Check Validate
            $request->validate([
                'image'    => 'nullable|mimes:jpeg,jpg,png|max:3145728',
                'name'     => 'required|max:100|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
                'email'    => 'required|unique:admins,email|max:200|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
                'role'     => 'required|in:administrator,blogger',
                'password' => 'required|min:6|max:255'
            ]);

            // Inputs
            $image    = $request->image;
            $name     = strtolower($request->name);
            $name     = ucfirst($name);
            $email    = $request->email;
            $role     = $request->role;
            $password = $request->password;

            $fileName = NULL;
            if ($request->hasFile('image')) {
                $fileName =  randomName('webp'); // Random File Name
            }



            $insert = Admins::create([
                "image"    => $fileName,
                "name"     => $name,
                "email"    => $email,
                "role"     => $role,
                "password" => Hash::make($password)
            ]);


            if ($insert->save()) {

                if ($request->hasFile('image')) {
                    image($image, $this->path,  $fileName, 128, 128);
                }
                $response = [
                    'status'  => true,
                    'message' => 'تم اضافة المشرف بنجاج',
                    'form'    => 'reset'
                ];
                return response($response);
            }
        } else {
            return redirect(adminUrl(""));
        }
    }

    public function profile()
    {
        return view("admin.managers.profile");
    }


    public function update_profile(Request $request)
    {

        $row = Admins::find(getAuth("admin", 'id')); // Get This Admin

        if ($row != null) { // Check If Isset This Row In DB

            // Check Validate
            $request->validate([
                'image'    => 'nullable|mimes:jpeg,jpg,png|max:3145728',
                'name'     => 'required|max:100|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
                'email'    => 'required|unique:admins,email,' . $row->id . '|max:200|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
                'password' => 'nullable|min:6|max:255'
            ]);


            // Inputs
            $image    = $request->image;
            $name     = strtolower($request->name);
            $name     = ucfirst($name);
            $email    = $request->email;





            // IF Password Null Set Old Password From DB Else Set New Passowrd And Hash
            $password = $request->password == '' ? $row->password : Hash::make($request->password);

            // Update Columns

            $row->name      = $name;
            $row->email     = $email;
            $row->password  = $password;

            if ($request->hasFile('image')) {
                // IF have New Image Delete Old
                @unlink($this->path . $row->image);
                $imgName = randomName('webp'); // Random File Name
                $row->image = $imgName;
                $image = $request->image;
                $row->image   = $imgName;
            }

            // Return Successfully Message
            if ($row->save()) {
                if ($request->hasFile('image')) {
                    image($image, $this->path,  $imgName, 128, 128);
                }
                $response = [
                    'status'  => true,
                    'message' => 'تم تعديل  بياناتك بنجاح',
               
                ];
                return response($response);
            }
        } else {

            return response(['status'  => 'forbidden']); // IF Not Isset Return Forbidden
        }
    }



    /**
     * Edit
     */
    // Display All Admins Page
    public function edit($id)
    {
        if (getAuth('admin', 'role') != 'administrator') {
            return redirect(adminUrl(""));
        }
        $row = Admins::find($id);
        return view("admin.managers.edit", compact("row"));
    }

    public function update(Request $request, $url_id)
    {
        if (getAuth('admin', 'role') == 'administrator') {
            try {

                $request_id = Crypt::decryptString($request->id); // Decrypt

                if ($request_id === $url_id) {

                    $row = Admins::find($request_id); // Get This Admin

                    if ($row != null) { // Check If Isset This Row In DB

                        // Check Validate
                        $request->validate([
                            'image'    => 'nullable|mimes:jpeg,jpg,png|max:3145728',
                            'name'     => 'required|max:100|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
                            'email'    => 'required|unique:admins,email,' . $row->id . '|max:200|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
                            'role'     => 'required|in:administrator,blogger',
                            'password' => 'nullable|min:6|max:255'
                        ]);


                        // Inputs
                        $image    = $request->image;
                        $name     = strtolower($request->name);
                        $name     = ucfirst($name);
                        $email    = $request->email;
                        $role     = $request->role;



                        // IF Password Null Set Old Password From DB Else Set New Passowrd And Hash
                        $password = $request->password == '' ? $row->password : Hash::make($request->password);

                        // Update Columns

                        $row->name      = $name;
                        $row->email     = $email;
                        $row->role      = $role;
                        $row->password  = $password;

                        if ($request->hasFile('image')) {
                            // IF have New Image Delete Old
                            @unlink($this->path . $row->image);
                            $imgName = randomName('webp'); // Random File Name
                            $row->image = $imgName;
                            $image = $request->image;
                            $row->image   = $imgName;
                        }


                        // Return Successfully Message
                        if ($row->save()) {

                            if ($request->hasFile('image')) {
                                image($image, $this->path,   $imgName, 128, 128);
                            }
                            $response = [
                                'status'  => true,
                                'message' => 'تم تعديل المشرف بنجاج'
                            ];
                            return response($response);
                        }
                    } else {

                        return response(['status'  => 'forbidden']); // IF Not Isset Return Forbidden
                    }
                } else {

                    return response(['status'  => 'forbidden']); // IF Input ID Not === The URL ID 
                }
            } catch (DecryptException $e) {

                return response(['status'  => false]);
            }
        } else {
            return redirect(adminPrefix() . '/admins');
        }
    }

    public function delete($id)
    {
        if (getAuth('admin', 'role') == 'administrator') {

            $row = Admins::find($id);

            if (file_exists($this->path . $row->image)) { // Delete File If Exist
                @unlink($this->path . $row->image);
            }

            $row->delete();

            return back();
        } else {
            return redirect(adminPrefix() . '/admins');
        }
    }
}
