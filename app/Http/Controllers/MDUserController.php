<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\RoleUser;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use Response;
use Image;
use Excel; 
use DB;
use App\Jobs\ImportJobKantor;
use Exception;
class MDUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function __construct(
    //     User $user )
    // {
    //     $this->photo = $photo;
    // }
    public function view()
    {
        //
       

        // return view('masterdata.MDUser',[
        //     'roles'=>$roles, 
        //     ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (request()->ajax()) {
            return datatables()->of(DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->join('md_penghasillimbah', 'md_penghasillimbah.id', '=', 'users.seksi')
            ->select(
                'users.id as id','md_penghasillimbah.seksi', 'users.name as name','users.email','roles.display_name as roles', 'users.created_at'
                )->latest()->get())
                    ->addColumn('action', 'action_button') 
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            
        } 
        $roles=DB::table('roles')->get()->toArray();
        $unit_kerja=DB::table('md_penghasillimbah')->get();
      
        return view('masterdata.MDUser',[
            'roles'=>$roles, 

            'unit_kerja'=>$unit_kerja
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        //
        // dd($request->unit_kerja);
        $rolesAdmin=Role::where('name','admin')->first();
        $rolesOperator=Role::where('name','operator')->first();
        $rolesUnitKerja=Role::where('name','unit kerja')->first();
        $rolesPengawas=Role::where('name','pengawas')->first();
        // dd($request);
        $rules = array(
            'name'      =>  'required',
            'unit_kerja'      =>  'required',
            'email'     =>  'required', 
            'roles'     =>  'required',
            'password'  =>  'nullable',
            // 'avatar'    =>  'nullable|image|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $defaultPhoto='default.jpg';
        $create=null;
       
        $form_datauser=array(
            'seksi'          =>  (int)$request->unit_kerja,
            'name'          =>  $request->name,
            'email'         =>  $request->email, 
            'password'      =>  bcrypt($request->password),
            // 'avatar'        =>  $defaultPhoto
        );
        // dd( $form_datauser);
 
        // if ($request->hasFile('avatar')) {
        //     $images = $request->file('avatar'); 
        //     //setting flag for condition
        //     $org_img = $thm_img = true;
        //     // dd($images->getClientOriginalName());
        //     // create new directory for uploading image if doesn't exist
        //     if( ! File::exists(AppHelper::pathFileFoto(''))) {
        //         $org_img = File::makeDirectory(AppHelper::pathFileFoto(''), 0777, true);
        //     } 
        //         //get file name of image  and concatenate with 4 random integer for unique
        //         // .'.'.$images->getClientOriginalExtension()
        //         $filename = $request->name.'_'.$images->getClientOriginalName();
        //         //path of image for upload
        //         $org_path = AppHelper::pathFileFoto($filename);
        //         $form_datauser['avatar']= $filename; 
        //         $create=User::create($form_datauser);
 
        //         //don't upload file when unable to save name to database
        //         if (! $create) {
        //             return response()->json(['errors' => "Gagal Simpan ke Database"]);
        //             // return false;
        //         }
        //             // $create->attachRole($rolesBeacukai); 
        //             switch($request->roles){
        //                 case "Admin":
        //                 $create->attachRole($rolesAdmin); 
        //                 break;
        //                 case "Operator":
        //                 $create->attachRole($rolesOperator); 
        //                 break;
        //                 case "Unit Kerja":
        //                     $create->attachRole($rolesUnitKerja); 
        //                     break;
        //                 default:
        //                 $create->attachRole($rolesPengawas);  
        //             }
        //             Image::make($images)->fit(300, 300, function ($constraint) {
        //                 $constraint->upsize();
        //             })->save($org_path);
        //             return response()->json(['success' => 'Foto Berhasil Di Upload']);
          
            
            // return redirect()->action('PengujianController@view', $request->hidden_id);
        // }else{
            // $form_datauser['avatar']= $defaultPhoto;
            $create=User::create($form_datauser);
 
            if ( ! $create) {
                return response()->json(['errors' => "Gagal Simpan ke Database"]);
                
            }
            switch($request->roles){
                case "Admin":
                    $create->attachRole($rolesAdmin); 
                    break;
                    case "Operator":
                    $create->attachRole($rolesOperator); 
                    break;
                    case "Unit Kerja":
                        $create->attachRole($rolesUnitKerja); 
                        break;
                    default:
                    $create->attachRole($rolesPengawas); 
            }
            
                return response()->json(['success' => 'Foto Berhasil Di Upload']);

        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user= DB::table('users')
       ->join('role_user', 'role_user.user_id', '=', 'users.id')
       ->join('roles', 'roles.id', '=', 'role_user.role_id')
       ->select(
           'users.id as id','users.avatar', 'users.name as name','users.email','roles.display_name as roles', 'users.created_at'
           )
                ->where('users.id',$id)->first(); 
 
    return Response::json($user); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        $rolesAdmin=Role::where('display_name','Admin')->first();
        $rolesUnitkerja=Role::where('display_name','Unit Kerja')->first();
        $rolesPengawas=Role::where('display_name','Pengawas')->first();
        $rolesOperator=Role::where('display_name','Operator')->first();
        // dd($request);
        $rules = array(
            'seksi'      =>  'required',
            'name'      =>  'required',
            'email'     =>  'required', 
            'roles'     =>  'required',
            'password'  =>  'nullable',
            // 'avatar'    =>  'nullable|image|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $defaultPhoto='default.jpg';
        $create=null;

        $form_datauser=array(
            'name'          =>  $request->name,
            'seksi'          =>  $request->unit_kerja,
            'email'         =>  $request->email, 
            // 'password'      =>  bcrypt($request->password),
            // 'avatar'        =>  $defaultPhoto
        );
        // dd($request->hidden_id);
        $getUser= User::find($request->hidden_id);
      
        // if ($request->hasFile('avatar')) {
            // $images = $request->file('avatar'); 
            // //setting flag for condition
            // $org_img = $thm_img = true;
 
            // // create new directory for uploading image if doesn't exist
            // if( ! File::exists(AppHelper::pathFileFoto(''))) {
            //     $org_img = File::makeDirectory(AppHelper::pathFileFoto(''), 0777, true);
            // }  
            //     //get file name of image  and concatenate with 4 random integer for unique
            //     $filename = $request->name.'_'.$images->getClientOriginalName();
            //     //path of image for upload
            //     $org_path = AppHelper::pathFileFoto($filename); 
            //     $form_datauser['avatar']= $filename;  
 
            //     //don't upload file when unable to save name to database
            //     if ( ! $getUser->update($form_datauser)) {
            //         return response()->json(['errors' => "Gagal Simpan ke Database"]);
                    
            //     }

            //     $getRoles=RoleUser::where('user_id',$request->hidden_id)->first();
               
            //     switch($getRoles->role_id){
            //         case "1": $getUser->detachRole($rolesAdmin);
            //             break;
            //         case "2": $getUser->detachRole($rolesOperator);
            //             break; 
            //             case "3": $getUser->detachRole($rolesUnitkerja);
            //         break; 
            //             default:$getUser->detachRole($rolesPengawas);
                   
            //     }  

            //     if($getRoles){
            //         switch ($request->roles) {
            //         case "Admin":
            //             $getUser->attachRole($rolesAdmin);
            //         break;
            //         case "Operator":
            //             $getUser->attachRole($rolesOperator); 
                   
            //         break;
            //         case "Unit Kerja":
            //             $getUser->attachRole($rolesUnitkerja); 
                   
            //         break;
            //         default:
            //         $getUser->attachRole($rolesPengawas); 
            //         // $getRoles->role_id='3';
            //     } 
            //     $form_datauser += [ "avatar" => $filename ]; 

            //     if($request->password != "" || $request->password != null ){
                    
            //         $form_datauser += [ "password" => bcrypt($request->password) ]; 
            //         $getRoles->save();
            //         $getUser->update($form_datauser);

            //     }else{
            //         $getRoles->save();

            //         $getUser->update($form_datauser);
            //     } 

            //     }
               

            //         Image::make($images)->fit(128, 128, function ($constraint) {

            //             $constraint->upsize();

            //         })->save($org_path);

            //         return response()->json(['success' => 'Update Berhasil']);
          
             
        // }else{
 
            
            if ( ! $getUser->update($form_datauser)) {

                return response()->json(['errors' => "Gagal Update ke Database"]);
              
            }
            $getRoles=RoleUser::where('user_id',$request->hidden_id)->first();
          
            switch($getRoles->role_id){
                case "1": $getUser->detachRole($rolesAdmin);
                    break;
                case "2": $getUser->detachRole($rolesOperator);
                    break; 
                    case "3": $getUser->detachRole($rolesUnitkerja);
                break; 
                    default:$getUser->detachRole($rolesPengawas);
               
            }  
 
             
            $rolesId=null;
            
            if($getRoles){

                switch ($request->roles) {

                    case "Admin":
                        $getUser->attachRole($rolesAdmin);
                    break;
                    case "Operator":
                        $getUser->attachRole($rolesOperator); 
                   
                    break;
                    case "Unit Kerja":
                        $getUser->attachRole($rolesUnitkerja); 
                   
                    break;
                    default:
                    $getUser->attachRole($rolesPengawas);  
            } 
            if($request->password != "" || $request->password != null){

                $form_datauser += [ "password" => bcrypt($request->password) ]; 

                $getRoles->save();

                $getUser->update($form_datauser);

            }else{

                $getRoles->save();

                $getUser->update($form_datauser);
            }
           
            }

                return response()->json(['success' => 'Update Data Berhasil']);

        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = User::findOrFail($id);
        $data->delete();
    }

    
}
