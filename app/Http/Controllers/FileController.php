<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Backup;
use App\Models\File;
use App\Models\Folder;
use App\Models\Group;
use App\Models\OtherFiles;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserField;
use App\Models\ValueList;
use App\Models\Version;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use Storage;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get();
        $metadata = UserField::get();
        $mainTab = 'files';
        $tags = Tag::pluck('name', 'id')->toArray();
        $folders = Folder::where('parent_id', 1)->orderBy('name', 'asc')->take(6)->pluck('name', 'id')->toArray();
        $uploadedBy = null;
        $requestMetadata = null;
        $reqDateCreated = null;
        $reqDateModified = null;
        $q = $request->q;


        $curr_folder = "";
        $curr_folder_id = (isset($request->fld)) ? $request->fld : 1;

        if($curr_folder_id > -1){
            $files = File::with('createdByUser', 'users','fields')->where('folder_id', $curr_folder_id);
            $curr_folder = Folder::withCount('files')->withCount('children')->find($curr_folder_id);

        }elseif($curr_folder_id == -2){ // deleted files...
            $files = File::onlyTrashed()->where('is_trash_cleared', FALSE)->with('createdByUser', 'auth_user','fields');
            $mainTab = 'users';
        }else{
            $files = File::with('createdByUser', 'auth_user', 'fields');
        }

        if(isset($request->q)){
            $files = $files->where('name', 'like', '%'.$request->q.'%');
        }

        if($request->has('uploadedby')) {
          $uploadedBy = $request->uploadedby;
          if(! is_null($uploadedBy))
            $files->where('created_by', $uploadedBy);
        }

        if($request->has('metadata')) {
          $requestMetadata = $request->metadata;
          if(! is_null($requestMetadata))
            $files->whereHas('fields', function($q) use ($requestMetadata){
              $q->where('id', '=', $requestMetadata);
            });
        }

        if($request->has('datecreated')) {
          $reqDateCreated = $request->datecreated;
          if(! is_null($reqDateCreated))
            $files->whereDate('created_at', '=', Carbon::parse($reqDateCreated)->toDateString());
        }

        if($request->has('datemodified')) {
          $reqDateModified = $request->datemodified;
          if(! is_null($reqDateModified))
            $files->whereDate('last_modified', '=', Carbon::parse($reqDateModified)->toDateString());
        }
      //dd($files->get());
        // if($request->isMethod("post")){

        //     // dd($request->all());
        //     $files = File::with('createdByUser', 'users')->where('folder_id', $request->fld);

        //     $folder = Folder::with('fields')->find($request->fld);

//     foreach ($folder->fields as $field) {
        //         $fld = 'fld_'.$field->id;
        //         $fldOpt = 'fld_opt_'.$field->id;
        //         $files = $files->whereHas('fields', function($q) use ($request, $field, $fld, $fldOpt){

        //                     $q->where( 'user_field_id', $field->id )->where('value', 'LIKE', '%'.$request->$fld.'%');
        //         });
        //     }

            
        // }

        // $files = $files->where("uncategorized", 0)->orderBy('created_at', 'desc')->get();
        // dd($files);
        if(Auth::user()->access_type == 'Limited Staff') {
            $files = $files->where("uncategorized", 0)->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->limit(300)->get();
        }
        else {

            $files = $files->where("uncategorized", 0)->orderBy('created_at', 'desc')->limit(300)->get();
        }

        
        // $files = $files->where("uncategorized", 0)->orderBy('created_at', 'desc')->limit(300)->get();

        $filter = true;
        //dd($files->toArray());
        



        return view('files.all', compact(
          'mainTab','users','metadata','filter', 'tags', 'folders',  'files', 'curr_folder_id', 'curr_folder', 'q',
          'uploadedBy', 'requestMetadata','reqDateCreated','reqDateModified'
        ));
    }


    public function search(Request $request)
    {
        $mainTab = 'files';
        $curr_folder_id = (isset($request->fld)) ? $request->fld : 1;
        $curr_folder = Folder::find($curr_folder_id);
        $folders = Folder::where('parent_id', 1)->orderBy('name', 'asc')->take(6)->pluck('name', 'id')->toArray();

        if(Auth::user()->access_type == 'Limited Staff') {
            $mainfiles = File::with('createdByUser', 'auth_user')->where('created_by', Auth::user()->id)->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
        }
        else {
            $mainfiles = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
        }


        // $mainfiles = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
        $metafiles = File::with('createdByUser', 'auth_user','fields')->where("uncategorized", 0)->whereHas('fields', function($q) use ($request ){ $q->where( 'file_user_field.value', 'like', '%'.$request->q.'%' ); })->orderBy('name', 'asc')->get();
        
        $files = $mainfiles->merge($metafiles);
        
        $q = $request->q;

        $filter = false;

        return view('files.all', compact('mainTab', 'folders', 'filter', 'files', 'curr_folder_id',
                         'curr_folder', 'q'));
    }


    public function quickSearch(Request $request)
    {

        if(Auth::user()->access_type == 'Limited Staff') {
            $files = File::with('createdByUser', 'auth_user')->where('created_by', Auth::user()->id)->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->take(5)->get();   

        }
        else {
            $files = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->take(5)->get();   

        }

        // $files = File::with('createdByUser', 'auth_user')->where("uncategorized", 0)->where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->take(5)->get();   

        $metafiles = File::with('createdByUser', 'auth_user','fields')->where("uncategorized", 0)->whereHas('fields', function($q) use ($request ){ $q->where( 'file_user_field.value', 'like', '%'.$request->q.'%' ); })->orderBy('name', 'asc')->take(5)->get();   

        // dd($metafiles->toArray()); 


        $folders = Folder::where('name', 'like', '%'.$request->q.'%')->take(5)->get();    
        
        $q = $request->q;

        // dump($files);
        return view('files.quick_search', compact('files', 'folders', 'metafiles', 'q'));
    }



    public function filePermissions(Request $request)
    {
        $file = File::with('users', 'groups')->find($request->id);

        $fileUsers = $file->users->toArray();
        $fileGroups = $file->groups->toArray();
        $files = array_merge($fileUsers, $fileGroups);

        // dd($file->toArray());

        $files = json_decode(json_encode($files));
        $permissions = [];



        foreach ($files as $key => $file) {

            // dump($file);

            $type = 'group';
            if(!isset($file->name)){
                $name = $file->last_name. ''.$file->first_name;
                $type = 'user';
            }
            else
                $name = $file->name;

            $permissions[] = ['id' => $file->id, 'type' =>$type,  'name' => $name, 'can_write' => $file->pivot->can_write, 'can_read' => $file->pivot->can_read, 'can_share' => $file->pivot->can_share, 'can_download' => $file->pivot->can_download, 'can_lock' => $file->pivot->can_lock, 'can_checkin'=>$file->pivot->can_checkin, 'can_force_checkin' => $file->pivot->can_force_checkin ];
        }


        return view('files.view.data', compact('permissions'));
    }


    public function removePermission(Request $request){
        $file = File::find($request->file_id);
        if($request->type == 'user'){
            DB::table('file_user')->where('file_id', $request->file_id)->where('user_id', $request->id)->delete();
        }else{
            DB::table('file_group')->where('file_id', $request->file_id)->where('group_id', $request->id)->delete();
        }
        $file->is_permission_set = 0;
        $file->save();
        return ['status' => 200];

    }

    public function updateFilePermissions(Request $request)
    {
        $file = File::find($request->file_id);
        $file->is_permission_set = 1;
        $attributes = [$request->property => $request->checked];

        // dd($request->all(), $attributes);
        if($request->type == 'user'){
            $file->users()->updateExistingPivot($request->id, $attributes);
        }else{
            $file->groups()->updateExistingPivot($request->id, $attributes);
        }

        return ['status' => 200];
    }


    public function folderPermissions(Request $request)
    {
        $file = Folder::with('users', 'groups')->find($request->id);


        $fileUsers = $file->users->toArray();
        $fileGroups = $file->groups->toArray();
        $files = array_merge($fileUsers, $fileGroups);

        
        $files = json_decode(json_encode($files));
        $permissions = [];



        foreach ($files as $key => $file) {

            // dump($file);

            $type = 'group';
            if(!isset($file->name)){
                $name = $file->last_name. ''.$file->first_name;
                $type = 'user';
            }
            else
                $name = $file->name;

            $permissions[] = ['id' => $file->id, 'type' =>$type,  'name' => $name, 'can_write' => $file->pivot->can_write, 'can_read' => $file->pivot->can_read, 'can_share' => $file->pivot->can_share, 'can_download' => $file->pivot->can_download, 'can_lock' => $file->pivot->can_lock, 'can_checkin'=>$file->pivot->can_checkin, 'can_force_checkin' => $file->pivot->can_force_checkin ];
        }

        $isFolder = true;


        return view('files.view.data', compact('permissions', 'isFolder'));
    }


    public function removeFolderPermission(Request $request){

        if($request->type == 'user'){
            DB::table('folder_user')->where('folder_id', $request->file_id)->where('user_id', $request->id)->delete();
        }else{
            DB::table('folder_group')->where('folder_id', $request->file_id)->where('group_id', $request->id)->delete();
        }

        return ['status' => 200];

    }

    public function updateFolderPermissions(Request $request)
    {
        $file = Folder::find($request->file_id);
        $attributes = [$request->property => $request->checked];

        
        if($request->type == 'user'){
            $file->users()->updateExistingPivot($request->id, $attributes);
        }else{
            $file->groups()->updateExistingPivot($request->id, $attributes);
        }

        return ['status' => 200];
    }


    public function viewFile(Request $request, $id, $isModal = FALSE)
    {
        $file  = File::withTrashed()->with('users', 'tags', 'folder', 'folder.workflow.steps', 'groups', 'versions', 'fields')->find($id);
        $folder = Folder::with('fields', 'workflow')->find($file->folder_id);

        $audits = ActivityLog::where('actionable_type', 'App\Models\File')->where('actionable_id', $id)->get();

        $users = User::get();
        $groups = Group::get();

        $workflowSteps = $file->folder->workflow ? $file->folder->workflow->steps : [];

        return view('files.detail', compact(
          'file','folder', 'users', 'audits', 'groups', 'isModal', 'workflowSteps'
        ));
    }

    public function preview(Request $request, $id)
    {
        $file  = File::withTrashed()->with('users', 'tags', 'folder', 'groups', 'versions', 'fields')->find($id);
        log_action(Auth::id(), 'File Preview', 'App\Models\User', $file->id, 'was previewed.');

        return view('files.view.preview', compact('file'));
    }

    public function versionPreview(Request $request, $id)
    {
        $version  = Version::with('file')->find($id);
        log_action(Auth::id(), 'File Preview', 'App\Models\User', $version->id, 'was previewed.');
        $otherFile = null;

        return view('files.view.version-preview', compact('version', 'otherFile'));
    }

    public function otherFilesPreview(Request $request, $id)
    {
        $otherFile  = OtherFiles::with('file')->find($id);
        log_action(Auth::id(), 'File Preview', 'App\Models\User', $otherFile->id, 'was previewed.');
        $version =null;

        return view('files.view.version-preview', compact('otherFile', 'version'));
    }

    public function createPermission(Request $request)
    {
        $file = File::find($request->id);
        $file->is_permission_set = 1;
        $file->save();
        // Check if Exists before
        if($request->type == 'user'){

            $user = DB::table('file_user')->where('user_id', $request->type_id)->where('file_id', $request->id)->first();
            if($user)
                return ['status' => 500];

            DB::table('file_user')->insert(
                ['user_id' => $request->type_id, 'file_id' => $request->id]
            );

        }elseif($request->type == 'group'){

            $group = DB::table('file_group')->where('group_id', $request->type_id)->where('file_id', $request->id)->first();

            if($group)
                return ['status' => 500];

            DB::table('file_group')->insert(
                ['group_id' => $request->type_id, 'file_id' => $request->id]
            );

        }


    }


    public function newFolderPermission($folderId)
    {
        if(! is_null($folderId)) {
            $folder = Folder::find($folderId);
            $folders = Folder::pluck('name', 'id')->toArray();
            $fields = UserField::pluck('name', 'id')->toArray();

            $users = User::get();
            $groups = Group::get();
            return view('files.categories.permission', compact(
              'folder', 'folders', 'fields', 'users', 'groups'
            ));
        }
    }

     public function createFolderPermission(Request $request)
    {
        $file = File::find($request->id);
        
        // Check if Exists before
        if($request->type == 'user'){

            $user = DB::table('folder_user')->where('user_id', $request->type_id)->where('folder_id', $request->id)->first();
            if($user)
                return ['status' => 500];

            DB::table('folder_user')->insert(
                ['user_id' => $request->type_id, 'folder_id' => $request->id, 'can_read' => TRUE]
            );

        }elseif($request->type == 'group'){

            $group = DB::table('folder_group')->where('group_id', $request->type_id)->where('folder_id', $request->id)->first();

            if($group)
                return ['status' => 500];

            DB::table('folder_group')->insert(
                ['group_id' => $request->type_id, 'folder_id' => $request->id, 'can_read' => TRUE]
            );

        }


    }


    public function newFileUpload(Request $request)
    {
        
        

        if ($request->isMethod('post')) {
            // dd($request->all());
            $isEdit = null;

            if ($request->hasFile('file')) {

                $count = 0;
                
                foreach ($request->file as $f) {

                    // dump($f);
                    $fileName = $f->getClientOriginalName();

                    // $ff = Storage::put('public', $f);
                    // $ff = Storage::disk('public')->put('public', $f);
                    // $ff = Storage::disk('files')->put('files', $f);

                    $arr = uploadFile($f);
                    // dump($arr);

                    $file = File::firstOrCreate([
                             'name'             => 'B-'.$this->getFileId(),
                             'size'             => $arr['size'],
                             'type'             => $arr['mimeType'],
                             'current_version'  => '1',
                             'last_modified'    => date('Y-m-d H:i:s', $arr['lastMod']),
                             'file_path'        => $arr['filePath'],
                             'folder_id'        => $request->folder_id,
                             'created_by'       => Auth::user()->id,


                        ]);


                    $version = Version::firstOrCreate([
                            'file_id'          => $file->id,
                            'size'             => $arr['size'],
                            'type'             => $arr['mimeType'],
                            'version'          => '1',
                            'file_path'        => $arr['filePath'],
                            'comments'         => "Initial upload.",
                            'created_by'       => Auth::user()->id,
                        ]);

                    $otherfile = OtherFiles::firstOrCreate([
                        'file_id'          => $file->id,
                        'size'             => $arr['size'],
                        'type'             => $arr['mimeType'],
                        'file_path'        => $arr['filePath'],
                        'name'             => str_ireplace("'", "", $fileName),
                        'created_by'       => Auth::user()->id,
                    ]);


                    //TODO set permissions
                    DB::table('file_user')->insert([
                                        'user_id'       => Auth::user()->id, 
                                        'file_id'       => $file->id,
                                        'can_read'      => TRUE,
                                        'can_write'     => TRUE,
                                        'can_download'  => TRUE,
                                        'can_lock'      => TRUE,
                                        'can_checkin'   => TRUE,
                                ]);




                    ++$count;
                    

                    

                    
                }

                log_action(Auth::id(), 'File Upload', 'App\Models\File', $file->id, $count.' files uploaded successfully');
                

                
            }

            return response()->json([
                        'success' => true,
                        'message' => "Files uploaded successfully!"
                    ]); 

        }
        //This takes care of blank upload to inititae workflow without uploading a file
                else{
                            
                    // $f = asset( 'public/doc/blank.pdf' );

                    $file = File::firstOrCreate([
                        'name'             => 'B-'.$this->getFileId(),
                        'size'             => 5000,
                        'type'             => 'pdf',
                        'current_version'  => '1',
                        'last_modified'    => date('Y-m-d H:i:s'),
                        'file_path'        => 'blank.pdf',
                        'folder_id'        => 1,
                        'created_by'       => Auth::user()->id,


                    ]);


                    $version = Version::firstOrCreate([
                            'file_id'          => $file->id,
                            'size'             => 5000,
                            'type'             => 'pdf',
                            'version'          => '1',
                            'file_path'        => date('Y-m-d H:i:s'),
                            'comments'         => "Initial upload.",
                            'created_by'       => Auth::user()->id,
                    ]);

                    $otherfile = OtherFiles::firstOrCreate([
                        'file_id'          => $file->id,
                        'size'             => 5000,
                        'type'             => 'pdf',
                        'file_path'        => 'blank.pdf',
                        'name'             => 'blank',
                        'created_by'       => Auth::user()->id,
                    ]);


                    //TODO set permissions
                    DB::table('file_user')->insert([
                                        'user_id'       => Auth::user()->id, 
                                        'file_id'       => $file->id,
                                        'can_read'      => TRUE,
                                        'can_write'     => TRUE,
                                        'can_download'  => TRUE,
                                        'can_lock'      => TRUE,
                                        'can_checkin'   => TRUE,
                                ]);
                    log_action(Auth::id(), 'File Upload', 'App\Models\File', $file->id, ' files uploaded successfully');
                    
                    return redirect()->route('file-categorize');
            
        }
    }


    public function UploadPage(Request $request)
    {
        $mainTab = 'files';

        return view('files.file-upload-page', compact('mainTab'));
    }


    public function storeFolder(Request $request, $parent_id = 1, $folder_id = null)
    {
        
        $folder = "";
        $folderFields = [];

        if($folder_id){

            // dump(str_ireplace("_anchor", "", $request->folder_id));
            // exit;

            $folder = Folder::find(str_ireplace("_anchor", "", $folder_id));
            $folderFields = $folder->fields()->pluck('id','name')->toArray();
        }

        

        if ($request->isMethod('post')) {


            // dd($request->all());
            $f = null;


            $parent_id  = (empty($request->parent_id)) ? 1 : $request->parent_id;
            $data = [
                        'name' => $request->name,
                        'created_by'    => Auth::user()->id,
                        'description'   => $request->description,
                        'parent_id'     => $parent_id,
                        
                    ];
            if(isset($request->preset_parent_id)){
                $f = Folder::find($request->preset_parent_id);
                $data['workflow_id']     = $f->workflow_id;
            }else{
                $data['workflow_id']     = $request->workflow_id;
            }        


            // checking workflow...
            $workflow = Workflow::find($data['workflow_id']);
            if($workflow){
            $metaIds = $workflow->metadata()->pluck('id')->toArray();
            $metaNames = implode(", ", $workflow->metadata()->pluck('name')->toArray());
            foreach ($metaIds as $mId) {
                if($request->fields && $request->compulsory_fields)
                {
                    $allFields = array_merge($request->fields, $request->compulsory_fields);
                }
                elseif($request->fields){
                 $allFields = $request->fields;
                }
                else $allFields = $request->compulsory_fields;    
                if(!in_array($mId, $allFields))
                    return response()->json([
                            'success' => false,
                            'message' => "The workflow metadata fields [".$metaNames."] are required to be part of the category metadata fields before the workflow can be attached to it."
                        ]); 
            }
        }

            


            
            if(!empty($folder)){
                
                $folder->update($data);

                log_action(Auth::id(), 'Update file category', 'App\Models\Folder', $request->folder_id, 'File category "'.$folder->name.'"" details was updated.');


            }else{

                if($this->checkIfFolderExist($request->name, $request->folder_id, $parent_id)){

                    return response()->json([
                            'success' => false,
                            'message' => "File category name already exist in the current folder"
                        ]); 

                }

                $folder = Folder::firstOrCreate([
                                    'name' => $request->name,
                                    'description'   => $request->description,
                                    'parent_id'     => $parent_id,
                                    'created_by'    => Auth::user()->id,
                                    'workflow_id'     => $request->workflow_id
                            ]);

                log_action(Auth::id(), 'Create file category', 'App\Models\Folder', $folder->id, 'File category "'.$folder->name.'" was successfully created.');

                //TODO set permission as that of parent ID...


            }

            if(isset($request->preset_parent_id)){

                $fieldIds = $f->fields()->pluck('id')->toArray();
                $folder->fields()->sync($fieldIds);
            }else{
                //compusory fields...
                $folder->fields()->detach();
                if($request->compulsory_fields){
                    foreach ($request->compulsory_fields as $f) {
                        $folder->fields()->attach($f, ['is_compulsory' => TRUE]);
                    }
                }
                if($request->fields){
                    foreach ($request->fields as $f) {
                        // if(!in_array($f, $request->compulsory_fields))
                            $folder->fields()->attach($f, ['is_compulsory' => FALSE]);       
                    }
                }
                // $folder->fields()->sync($request->fields);
            }



            return response()->json([
                        'success' => true,
                        'message' => "File category has been saved successfully!"
                    ]); 

        }

        $folders = Folder::pluck('name', 'id')->toArray();
        $defaultFields = UserField::pluck('name', 'id')->toArray();
        $fields = UserField::pluck('id', 'name')->toArray();
        $customFields = array_merge($folderFields, array_diff($fields, $folderFields));

        if ($folder) {
            $compulsory_field_ids = $folder->fields()->where('is_compulsory', TRUE)->pluck('id')->toArray();
            $other_field_ids = $folder->fields()->where('is_compulsory', FALSE)->pluck('id')->toArray();
        }else{
            $compulsory_field_ids = [];
            $other_field_ids = [];
        }

        $customOtherFieldsExcept = array_diff($fields, $other_field_ids);

        $customOtherFields = [];
        foreach ($other_field_ids as  $otherFieldId)
            $customOtherFields[$defaultFields[$otherFieldId]] = $otherFieldId;

        $customOtherFields = $customOtherFields + $customOtherFieldsExcept;
        $customFieldsList = [];
        foreach ($customFields as $field => $id) {
            $customFieldsList[] = [ 'id' => $id,  'name' => $field ];
        }
        $workflows = ['' => '-Choose-'] + Workflow::pluck('name', 'id')->toArray();

        return view('files.folder-form', compact('folder', 'folders', 'fields', 'folderFields', 'workflows',
          'parent_id', 'compulsory_field_ids', 'other_field_ids', 'customFieldsList', 'defaultFields', 'customOtherFields'
        ));
        
    }


    public function permFolder(Request $request)
    {
        
        $folder = "";

        if(isset($request->folder_id)){

            // dump(str_ireplace("_anchor", "", $request->folder_id));
            // exit;

            $folder = Folder::find(str_ireplace("_anchor", "", $request->folder_id));
            $folderFields = $folder->fields()->pluck('id')->toArray();
        }

        

        if ($request->isMethod('post')) {

            // dd($request->all());

            $parent_id  = (empty($request->parent_id)) ? 1 : $request->parent_id;

            if($this->checkIfFolderExist($request->name, $request->folder_id, $parent_id)){

                return response()->json([
                        'success' => false,
                        'message' => "File category name already exist in the current folder"
                    ]); 

            }

            
            if(!empty($folder)){
                
                $folder->update([
                        'name' => $request->name,
                        'created_by'    => Auth::user()->id,
                        'description'   => $request->description,
                        'parent_id'     => $parent_id
                    ]);

                log_action(Auth::id(), 'Update File category', 'App\Models\Folder', $request->folder_id, 'File category "'.$folder->name.'" details was updated.');


            }else{

                $folder = Folder::firstOrCreate([
                                    'name' => $request->name,
                                    'description'   => $request->description,
                                    'parent_id'     => $parent_id
                            ]);

                log_action(Auth::id(), 'Create File category', 'App\Models\Folder', $folder->id, 'File category "'.$folder->name.'" was successfully created.');

                //TODO set permission as that of parent ID...


            }

            $folder->fields()->sync($request->fields);



            return response()->json([
                        'success' => true,
                        'message' => "File category has been saved successfully!"
                    ]); 

        }

        $folders = Folder::pluck('name', 'id')->toArray();
        $fields = UserField::pluck('name', 'id')->toArray();

        $users = User::get();
        $groups = Group::get();

        return view('files.categories.permission', compact('folder', 'folders', 'fields', 'folderFields', 'users', 'groups'));
        
    }


    public function trashUserField(Request $request)
    {
        
        $field = UserField::withCount('folders')->find($request->field_id);
        if(!$field){
            return response()->json([
                        'success' => false,
                        'message' => "Metadata field cannot be found."
                    ]); 
        }

        $field_name = $field->name;
        // trashing parent folders and files...

        // dump($field->toArray());

        
        if( $field->folders_count == 0 ){

            log_action(Auth::id(), 'Removed Metadata Fields', 'App\Models\UserField', $field->id, 'Metadata field "'.$field_name.'" was removed.');

            $field->delete();


            return response()->json([
                    'success' => true,
                    'message' => "Metadata field has been removed successfully!"
                ]); 
        }

        else{

            $folder_names = $field->folders()->pluck('name')->toArray();
            return response()->json([
                    'success' => false,
                    'message' => "Metadata field is attached to some categories ( ". implode(', ', $folder_names) ." ). It has to be detached before it can be removed.!"
                ]); 
        }



            

    
        
    }

    public function trashFolder(Request $request)
    {
        
        $folder = Folder::with('children')->find($request->folder_id);
        if(!$folder){
            return response()->json([
                        'success' => false,
                        'message' => "File category cannot be found."
                    ]); 
        }

        $folder_name = $folder->name;
        // trashing parent folders and files...
        if( $this->trashFileFolder($folder) ){

            log_action(Auth::id(), 'Removed Folder', 'App\Models\Folder', $folder->id, 'File category "'.$folder_name.'" was removed.');


            return response()->json([
                    'success' => true,
                    'message' => "File category has been removed successfully!"
                ]); 
        }

        else

            return response()->json([
                    'success' => false,
                    'message' => "File category has some files in it. The folder has to be empty before it can be removed!"
                ]); 

    
        
    }

    private function trashFileFolder($folder){

        

        $childFiles = File::where('folder_id', $folder->id)->get();

        if($childFiles->count() > 0)
            return false;

        //remove child files before deleting...
        // foreach ($childFiles as $childFile) {
        //     $childFile->delete();
        // }

        // $this->trashFolderChildren($folder->children);



        $folder->delete();

        return true;

    }


    public function editFile($fileId, Request $request){
        $isEdit =true;
        $mainTab = "files";
        $file = File::with('folder.fields', 'fields')->find($fileId);
        $saved = FALSE;
        $folders = Folder::where('name', '<>', 'root')->pluck('name', 'id')->toArray();

        if(!$file)
            return redirect()->route('all-files');

        if ($request->isMethod('post')) {
          
            $folder = Folder::with('fields', 'workflow')->find($request->folder_id);
            $data = $request->all();

            if($folder->workflow){
                /* This block of code handles the workflow update audit */
                
                $file_metadatas_ids = []; //this stores all the metadatas id that the particular file belongs to
                //Get the metadatas of the workflow step where the file is currently at
                $file_step_metadatas =  WorkflowStep::find($file->workflow_step_id);
                //loops through and save the ids in an array
                foreach($file_step_metadatas->metadata as $file_step_metadata) {
                    $file_metadatas_ids[] = 'fld_'.$file_step_metadata->id;
                }

                // dd($file_metadatas_ids);

                foreach($request->all() as $key =>$metadata) {
                    if(in_array($key, $file_metadatas_ids)) { //This checks if request key of the metadata is in the array of the metadata from file metadata id
                        $mId = str_replace("fld_", "",$key);
                        $meta = UserField::find($mId);
                        log_action(Auth::id(), 'Workflow update', 'App\Models\File', $file->id, $meta->name.' was updated to '.$metadata.' in '.$file_step_metadatas->name.' state ('.$file->name.')' , $metadata);
                    }
                }

                 /* End of block of code that handles the workflow update audit */

                // dump($file->workflow_step_id);

                // dd($this->checkWorkflowPreconditions($file->workflow_step_id, $data));

                //Duplicate control request from Beamco for Requsition
            
                if($folder->workflow->name == 'REQUISITION') {
                    $reqInvoice = $data['fld_43'];
                    $reqSupplierName = $data['fld_46'];
                    // dd($reqSupplierName);

                    if(!is_null($reqInvoice) && !is_null($reqSupplierName)){

                        $invoices = DB::table('file_user_field')->select('value', 'file_id')->where('file_id','<>', $request->file_id)->where('user_field_id', 43) ->get();
                        foreach($invoices as $invoice){
                            if($invoice->value == $reqInvoice){
                                
                                $suppilerName = DB::table('file_user_field')->select('value')->where('file_id', $invoice->file_id)->where('user_field_id', 46)->first();
                                // dd($suppilerName->value);
                                if($suppilerName->value == $reqSupplierName){
                                    // dd('caught you');
                                        return redirect()->back()->with('error', 'The invoice number '.$reqInvoice.' already exist for '.$reqSupplierName );
                                }
                            }
                                
                        }
                    }

                }

                // checking workflow pre-conditions...
                if(! $this->checkWorkflowConditions($file->workflow_step_id, $data) )
                    return redirect()->back()->with('error', 'You cannot index a file into that workflow state. The pre-conditions have not been met. The conditions are: <br/><br/><br/>'. getWorkflowStepConditions($file->workflow_step_id) .'');


            }



            $file->name = $request->name;
            $file->folder_id = $request->folder_id;
            $file->last_modified = date('Y-m-d H:i:s');

            
            
            $fLabel = "fld_";
            $file->fields()->detach();
            $data = $request->all();

            $folder = Folder::with('fields')->find($request->folder_id);


            foreach ($folder->fields as $field) {
                $val = (is_array($data[$fLabel.$field->id])) ? implode(",", $data[$fLabel.$field->id]) : $data[$fLabel.$field->id];

                $file->fields()->attach($field->id, ['value' => $val]);
            }

            $file->save();

            $request->session()->flash('success', 'File metadata was saved successfully!');
            log_action(Auth::id(), 'File edit', 'App\Models\File', $file->id, 'File '.$file->name.' has been edited');
            $saved = TRUE;

            if($folder->workflow){

            //issue notificatons...
            // doStepNotification($file);
            
            // //notify assignees...
            // doStepAssigneeNotification($file);

            //checking for triggers...
                $performedTrigger = true;
                if(! $this->doCombinedTriggers($file)) {
                    //Do regular trigger if combined trigger rules are not met
                    $performedTrigger = $this->doTriggers($file);
                }
		if(!$performedTrigger)
              $request->session()->flash('error', 'An error occurred as Workflow step does not meet condition');
          
            }
              
            return redirect()->route('dashboard');

        }

        
        return view('files.edit', compact('mainTab', 'file', 'saved', 'folders', 'isEdit'));
    }

    public function manualTrigger($fileId, $stepId, Request $request) {
        $file = File::with('folder.fields', 'fields')->find($fileId);

        if(!$file)
          return redirect()->route('all-files');

        $folder = $file->folder;
        if($folder->workflow){
            if(! $this->checkWorkflowConditions($file->workflow_step_id, []) )
                return redirect()->route('all-files','fld=-1')->with('error', 'You cannot index a file into that workflow state. The pre-conditions have not been met. The conditions are: <br/><br/><br/>'. getWorkflowStepConditions($file->workflow_step_id) .'');

            //issue notificatons...
            doStepNotification($file);

            //notify assignees...
            doStepAssigneeNotification($file);

            //checking for triggers...
            $performedTrigger = true;
            if(! $this->doCombinedTriggers($file)) {
              //Do regular trigger if combined trigger rules are not met
              $performedTrigger = $this->doTriggers($file);
            }
        }

        if(!$performedTrigger)
          return redirect()->route('all-files','fld=-1')->with('error', 'An error occurred as Workflow step does not meet condition');
        else
          return redirect()->route('all-files','fld=-1')->with('success', 'Moved to step successfully');
    }


    public function categoryFields($catId, $fileId, Request $request){

        $mainTab = "files";
        $folder = Folder::with('fields', 'workflow')->find($catId);
        // dd($folder->workflow);
        $file = \App\Models\File::with('step')->find($fileId);
        // dd($file);

        return view('files.category-fields', compact('folder', 'file'));
    }

    public function deleteFile($fileId)
    {
        $file = File::find($fileId);

        if($file)
        log_action(Auth::id(), 'File deleted', 'App\Models\File', $file->id, 'File "'.$file->name.'"  was deleted.');
            $file->delete();


        return redirect()->back();
    }

     public function restoreFile($fileId)
    {
        $file = File::withTrashed()->find($fileId);

        if($file)
            $file->restore();


        return redirect()->back();
    }

    private function trashFolderChildren($children){
        foreach ($children as $folder) {
            
            $this->trashFileFolder($folder);
        }
    }

    private function checkIfFolderExist($folder_name, $id = NULL, $parent_id = NULL)
    {
        if($parent_id == null)
            $parent_id = 1;

        $count = Folder::where('name', $folder_name)
                        ->where('parent_id', $parent_id)
                        ->where('id', '<>', $id)
                        ->count();

        return $count > 0;
    }


    public function folderBreakdown(Request $request)
    {

        $parent_id = (isset($request->parent) && ($request->parent != '#')) ? $request->parent : null;
        $folders = Folder::with(['groups', 'users'])->where('parent_id', $parent_id)
          ->orderBy('name')->withCount('children')->get();

        $fArr = [];
        
        foreach ($folders as $folder) {
            if(! is_null($parent_id)) {
                $canWrite = false;
                if($folder->groups->isEmpty() && $folder->users->isEmpty()) {
                    //No Permissions exist on folder
                    $canWrite = true;
                }else {
                    //Permission exist check if user has permission
                    if (! $folder->groups->isEmpty()) {
                        //Check if user is in groups
                        $folderGroups = $folder->groups->load('users');
                        foreach ($folderGroups as $folderGroup) {
                            $userExists = $folderGroup->users->find(Auth::user()->id);
                            if ($userExists) {
                                $permissionCanWrite = $folderGroup->pivot->can_write;
                                $canWrite = ($permissionCanWrite == 0) ? false : true;
                            }
                        }
                    }

                    if (! $folder->users->isEmpty() && $canWrite == false) {
                        if ($folder->users->find(Auth::user()->id)) {
                            $permissionCanWrite = $folder->users->find(Auth::user()->id)->pivot->can_write;
                            $canWrite = ($permissionCanWrite == 0) ? false : true;
                        }
                    }
                }
            } else {
                $canWrite = true;
            }

            if($canWrite) {
                $arr = [
                  'id' => $folder->id,
                  'icon' => "fa fa-folder icon-lg m--font-success",
                  'text'  => $folder->name,
                  'children' => ($folder->children_count > 0)
                ];

                $fArr[] = (Object)$arr;
            }
        }
        
        return response()->json($fArr); 

    }


    public function checkIn($id =null, Request $request)
    {
        if(!$id)
            $id = $request->fileId;

        $file = File::find($id);

        if($request->isMethod('post')){

            
            
            if ($request->hasFile('checkinfile')) {

                    $f = $request->checkinfile;
                    $fileName = $f->getClientOriginalName();

                    $arr = uploadFile($f);
                    $new_version = number_format($file->current_version + 1);
                    // dd($new_version);


                    $file->update([
                             'size'             => $arr['size'],
                             'type'             => $arr['mimeType'],
                             'current_version'  => $new_version,
                             'last_modified'    => date('Y-m-d H:i:s', $arr['lastMod']),
                             'file_path'        => $arr['filePath'],
                             'created_by'       => Auth::user()->id,
                             'checked_in_by'    => Auth::user()->id,
                             'is_locked'        => FALSE,
                             'is_checked_in'    => FALSE,


                        ]);


                    $version = Version::firstOrCreate([
                            'file_id'          => $file->id,
                            'size'             => $arr['size'],
                            'type'             => $arr['mimeType'],
                            'version'          => $new_version,
                            'file_path'        => $arr['filePath'],
                            'comments'         => $request->comments,
                            'created_by'       => Auth::user()->id,
                        ]);


                   
                log_action(Auth::id(), 'File Checkin', 'App\Models\File', $file->id, 'File "'.$file->name.'"  was checked in.');

                    
                
                
                 // return response()->json([
                 //        'success' => true,
                 //        'message' => "Files uploaded successfully!"
                 //    ]); 

                return redirect()->back()->with('success', 'File was checked in successfully');
                
            }

        }

        return view('files.file-checkin', compact('file'));
    }

    public function upload($id =null, Request $request) {
        if(!$id)
            $id = $request->fileId;

        $file = File::find($id);

        if($request->isMethod('post')){

            if ($request->hasFile('newfiles')) {

                foreach($request->newfiles as $newFile) {
                    $f = $newFile;
                    // dd($f);
                    $fileName = $f->getClientOriginalName();
                    // dd($fileName);
    
                    $arr = uploadFile($f);
    
    
    
                    $otherfile = OtherFiles::firstOrCreate([
                            'file_id'          => $file->id,
                            'size'             => $arr['size'],
                            'type'             => $arr['mimeType'],
                            'file_path'        => $arr['filePath'],
                            'name'             => $fileName,
                            'created_by'       => Auth::user()->id,
                        ]);
    
    
              
                    log_action(Auth::id(), 'File Uploaded', 'App\Models\File', $otherfile->id, 'File "'.$otherfile->name.'"  was uploaded.');
                }

           
                return redirect()->back()->with('success', 'File was uploaded successfully');
            }
        }

        return view('files.file-upload-new', compact('file'));
    }

     public function lockFile($id, $type)
    {

        $file = File::find($id);

        $file->update([ 'is_locked' => $type, 'locked_by' => Auth::id() ]);

        // dump($type);
        // dd($file->toArray());

        log_action(Auth::id(), 'Lock File', 'App\Models\File', $file->id, 
                'File "'.$file->name.'"  was '.($type)?"locked":"unlocked");

        

        return redirect()->back()->with('success', 'File has been '.($type)?"locked":"unlocked");
    }


    public function checkOut(Request $request, $fileId)
    {
        $file = File::find($fileId);
        $file->is_locked = TRUE;
        $file->is_checked_in = TRUE;
        $file->checked_in_by = Auth::user()->id;
        $file->locked_by = Auth::user()->id;
        $file->save();

        log_action(Auth::id(), 'CheckOut File', 'App\Models\File', $file->id, 'File "'.$file->name.'" was checked out.');

        return "true";
    }

    public function download(Request $request, $fileId)
    {
        $file = File::find($fileId);
        log_action(Auth::id(), 'Download File', 'App\Models\File', $file->id, 'File "'.$file->name.'" was dowloaded.');

        return "true";
    }

    public function export(Request $request, $fileId)
    {
        $dataId = File::with('folder.fields')->find($fileId);
        // dd($dataId);
        $message = $dataId->folder->description;
        $folder = Folder::find($dataId->folder->id);
        $firstMetadata = $folder->workflow->metadata()->pluck('name', 'id')->toArray(); //gets the metadatas of all associated files in the folder
        $filenameMetadata = File::find($fileId)->fields()->where('id', 45)->pluck('name', 'id')->toArray(); //gets the actual file name
        // $filenameMetadata = DB::table('file_user_field')->select('value')->where('file_id', $file_id)->where('user_field_id', 46)->first();
        // dd($filenameMetadata);
        $metadata = $firstMetadata  + $filenameMetadata; //combines both metadatas together in a single array
        // dd($metadata);
        

        foreach($metadata as $key => $value)
        {
            $fld = $dataId->fields()->where('id',$key)->first();
            // dd($fld);
            if($fld){
                $val = $fld->pivot->value;
                if($fld->type == "Number"){
                    $val = number_format($fld->pivot->value);
                } 
                elseif($fld->type == "Decimal"){
                    $val = number_format($fld->pivot->value, 2);
                }
            }
            else
                $val = '';
                // dd($val);
            $message = str_ireplace(strtolower("{{".$value."}}"), $val, $message);
            // $message = str_ireplace(strtolower("{{name}}"), $val, $message);
            // dd($message);

        }
        // dd($message);

        $pdf = PDF::loadHTML($message);
        // dd($pdf);
        log_action(Auth::id(), 'Export File', 'App\Models\File', $fileId, 'File "'.$dataId->name.'" was exported.');

        return $pdf->stream($dataId->name.'.pdf');
    }

    public function categorize(Request $request)
    {
        $isEdit = null;
        $folders = Folder::where('name', '<>', 'root')->pluck('name', 'id')->toArray();
       
        $folder = Folder::with('fields', 'workflow')->find($request->folder_id);

        if ($request->isMethod('post')) {

            //  dump($request->all());

            $file = File::with('folder.fields')->where('created_by', Auth::user()->id)->find($request->file_id);

            $file->name = $request->name;
            $file->folder_id = $request->folder_id;

            $fLabel = "fld_";
            $file->fields()->detach();
            $data = $request->all();

            //Duplicate control request from Beamco for Requsition
            if($folder->workflow){
                /* This block of code handles the workflow update audit */
                
                $file_metadatas_ids = []; //this stores all the metadatas id that the particular file belongs to
                //Get the metadatas of the workflow step where the file is currently at
                $file_step_metadatas =  WorkflowStep::find(1);
                //loops through and save the ids in an array
                foreach($file_step_metadatas->metadata as $file_step_metadata) {
                    $file_metadatas_ids[] = 'fld_'.$file_step_metadata->id;
                }

                // dd($file_metadatas_ids);

                foreach($request->all() as $key =>$metadata) {
                    if(in_array($key, $file_metadatas_ids)) { //This checks if request key of the metadata is in the array of the metadata from file metadata id
                        $mId = str_replace("fld_", "",$key);
                        $meta = UserField::find($mId);
                        log_action(Auth::id(), 'Workflow update', 'App\Models\File', $file->id, $meta->name.' was updated to '.$metadata.' in '.$file_step_metadatas->name.' state ('.$file->name.')' , $metadata);
                    }
                }

                 /* End of block of code that handles the workflow update audit */

                if($folder->workflow->name == 'REQUISITION') {
                    $reqInvoice = $data['fld_43'];
                    $reqSupplierName = $data['fld_46'];
                    // dd($reqSupplierName);

                    if(!is_null($reqInvoice) && !is_null($reqSupplierName)){

                        $invoices = DB::table('file_user_field')->select('value', 'file_id')->where('file_id','<>', $request->file_id)->where('user_field_id', 43) ->get();
                        foreach($invoices as $invoice){
                            if($invoice->value == $reqInvoice){
                                
                                $suppilerName = DB::table('file_user_field')->select('value')->where('file_id', $invoice->file_id)->where('user_field_id', 46)->first();
                                // dd($suppilerName->value);
                                if($suppilerName->value == $reqSupplierName){
                                    // dd('caught you');
                                        return redirect()->back()->with('error', 'The invoice number '.$reqInvoice.' already exist for '.$reqSupplierName );
                                }
                            }
                                
                        }
                    }

                }
            }



            $folder = Folder::with('fields', 'workflow')->find($request->folder_id);
            
            if($folder->workflow){
                $file->workflow_step_id = $folder->workflow->steps()->first()->id;

                // dump($file->workflow_step_id);

                // dd($this->checkWorkflowPreconditions($file->workflow_step_id, $data));

                // checking workflow pre-conditions...
                if(! $this->checkWorkflowConditions($file->workflow_step_id, $data) )
                    return redirect()->back()->with('error', 'You cannot index a file into that workflow state. The pre-conditions have not been met. The conditions are: <br/><br/><br/>'. getWorkflowStepConditions($file->workflow_step_id) .'');
            }




            foreach ($folder->fields as $field) {
              
                $val = (is_array($data[$fLabel.$field->id])) ? implode(",", $data[$fLabel.$field->id]) : $data[$fLabel.$field->id];

                $file->fields()->attach($field->id, ['value' => $val]);
            }
            $file->fields()->attach(45, ['value' => $request->name]);

            $file->uncategorized = FALSE;
            $file->save();

            $request->session()->flash('success', 'File was indexed successfully!');


            log_action(Auth::id(), 'File indexed', 'App\Models\File', $file->id, 'File "'.$file->name.'" was indexed.');

            if($folder->workflow){
            //issue notificatons...
            // doStepNotification($file);

            
            // //notify assignees...
            // doStepAssigneeNotification($file);


            //checking for triggers...
                if(! $this->doCombinedTriggers($file)) {
                    //Do regular trigger if combined trigger rules are not met
                    $this->doTriggers($file);
                }
            }
        }    

        $mainTab = 'files';
        $uncategorized_count = File::where("uncategorized", 1)->where('created_by', Auth::user()->id)->count();

        $file = File::with('folder.fields')->where('uncategorized', 1)->where('created_by', Auth::user()->id)->orderBy("created_at", 'desc')->first();

        if(!$file)
            return redirect()->route('all-files', ['fld'=> -1 ])->with('success', 'You don\'t have any file to index!');

    
        
        

        return view('files.categorize', compact('file', 'uncategorized_count', 'mainTab', 'folders',  'isEdit'));

    }


    private function checkWorkflowConditions($workflow_step_id, $reqData, $file = NULL, $mode = 'PRE'){

        $step = WorkflowStep::with('preConditions', 'postConditions')->find($workflow_step_id);
        $fLabel = "fld_";

        if($mode == 'PRE')
            $conditions = $step->preConditions;
        else
            $conditions = $step->postConditions;

        // dump($step->toArray());

        foreach ($conditions as $cond) {

            // dump($fLabel.$cond->user_field_id);

            // dump($cond->toArray());
            
            if(!empty($reqData)) 
                $val = (is_array($reqData[$fLabel.$cond->user_field_id])) ? implode(",", $reqData[$fLabel.$cond->user_field_id]) : $reqData[$fLabel.$cond->user_field_id];
            else{

                $fld = $file->fields()->where('id', $cond->user_field_id)->first();
                // checking if value exist
                if($fld)
                    $val = $fld->pivot->value;
                else
                    $val = '';
            }

            // dump($val);

            $arr = explode("::--::", $cond->value);
            $value = $arr[0];
            $val2 = '';
            if(isset($arr[1]))
                $val2 = $arr[1];
            if(!checkCondition($val, $cond->operator, $value, $val2))
                return false;


        }

        return true;
    }

    private function doTriggers($file): bool {

        // dump($file->toArray());

        // checking workflow post-conditions...
        // continue with trigger check only if post conditions have been met
        if( $this->checkWorkflowConditions($file->workflow_step_id, [], $file, 'POST') ){ 

            // dump("Got here...");

            $step = WorkflowStep::with('triggers.newStep')->find($file->workflow_step_id);
            $nextStep = WorkflowStep::where('workflow_id', '=', $step->workflow_id)->where('rank', '>', $step->rank)->orderBy('rank', 'asc')->first();
            foreach ($step->triggers as $trigger) {

                $val = @$file->fields()->where('id', $trigger->user_field_id)->first()->pivot->value;

                if(!$val)
                    continue;

                $arr = explode("::--::", $trigger->value);
                $value = $arr[0];
                $val2 = '';
                if(isset($arr[1]))
                    $val2 = $arr[1];

                if(checkCondition($val, $trigger->operator, $value, $val2)){
                    $nextStep = $trigger->newStep;
                    break;
                }
                // dd($nextStep);
            }

            // dd($nextStep);
            // dump($nextStep->toArray());
            // dump($step->toArray());

            if($nextStep){
                 //moving to new step...
                if( $this->checkWorkflowConditions($nextStep->id, [], $file, 'PRE') ){ 
                    //met the new step pre-conditions...
                    
                    // dump("Got here...2");

                    $file->workflow_step_id = $nextStep->id;
                    $file->save();

                    // dump($file->toArray());

                    //issue notificatons...
                    doStepNotification($file);

                    //notify assignees...
                    doStepAssigneeNotification($file);

                    return true;



                }
            }

           

        }

        return false;

    }

    private function doCombinedTriggers($file): bool {
        // checking workflow post-conditions...
        // continue with trigger check only if post conditions have been met
        if( $this->checkWorkflowConditions($file->workflow_step_id, [], $file, 'POST') ){
            $step = WorkflowStep::with('combinedTriggers.newStep')->find($file->workflow_step_id);
            $nextStep = null;
            $passedCombinedTriggersCount = 0;
            foreach ($step->combinedTriggers as $index => $trigger) {
                $val = @$file->fields()
                  ->where('id', $trigger->user_field_id)
                  ->first()->pivot->value;

                if(!$val)
                    continue;

                $arr = explode("::--::", $trigger->value);
                $value = $arr[0];
                $val2 = '';
                if(isset($arr[1]))
                    $val2 = $arr[1];

                if(checkCondition($val, $trigger->operator, $value, $val2)){
                    ++$passedCombinedTriggersCount;
                    //Assign next step if matches all rules
                    if($index === $step->combinedTriggers->count() - 1) {
                        if($passedCombinedTriggersCount === $step->combinedTriggers->count())
                            $nextStep = $trigger->newStep;
                    }
                }
            }

            if(is_null($nextStep)) {
                return false;
            }

            //moving to new step...
            if( $this->checkWorkflowConditions($nextStep->id, [], $file, 'PRE') ){
                return true;
                //met the new step pre-conditions...
                $file->workflow_step_id = $nextStep->id;
                $file->save();

                //issue notificatons...
                doStepNotification($file);

                //notify assignees...
                doStepAssigneeNotification($file);
            }
        }
        return false;
    }

    public function cancelIndexing($fileId)
    {
        $file = File::find($fileId);

        log_action(Auth::id(), 'Cancel Indexing', 'App\Models\File', $file->id, 'Indexing cancelled');

        $file->delete();
        return redirect()->route('file-categorize');
    }

    public function userFields(Request $request)
    {
         
         $mainTab = 'file-controls';
         $userFields = UserField::with('list')->get();


         return view('files.user-fields.list', compact('userFields', 'mainTab'));


    }


    public function storeUserField(Request $request)
    {
        
        $mainTab = 'files';

        if($request->id)
            $field = UserField::find($request->id);
        else
            $field = null;

        if($request->isMethod('post')){
            
            if(!@$field)
                $field = UserField::FirstorCreate([ 'name' => $request->name, 'title' => "", 'type' => $request->type, 'value_list_id' => $request->value_list_id ]);
            else
                $field->update( [ 'name' => $request->name, 'title' =>"", 'type' => $request->type, 'value_list_id' => $request->value_list_id ] );

            log_action(Auth::id(), 'User Field Created', 'App\Models\UserField', $field->id, 'Metadata "'.$request->name.'" was updated');

            return ['status' => '200', 'data' => $field ];
        }

        
        $vlists = ValueList::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        // dump($request);
        return view('files.user-fields.store', compact('mainTab', 'field', 'vlists'));
    }


    public function fileCategories(Request $request, $catId = 1)
    {
        
        $mainTab = 'file-controls';
        $category = null;

        $category = null;


        $categories = Folder::where('parent_id', $catId)->withCount('files')->withCount('children')->orderBy('name', 'asc')->get();

        if($catId > 1){
            $category = Folder::withCount('files')->withCount('children')->find($catId);
        }

        
        
        return view('files.categories.cards', compact('categories', 'mainTab', 'category'));
        
    }


    public function emptyTrash(Request $request)
    {
        if( in_array( Auth::user()->access_type, ["DATAMAX ADMIN", "SPECIAL ADMIN"])){

            File::onlyTrashed()->where('is_trash_cleared', FALSE)->update([
                          'is_trash_cleared' => TRUE  
                    ]);

            return redirect()->back()->with('success', 'Trash emptied successfully.');
        }

        else
            return redirect()->back()->with('error', 'You dont have the permission to empty trash.');

        
    }

    public function duplicateFolder(Request $request)
    {
        
        $folder = Folder::find($request->folder_id);


        // dd($folder);
        if(!$folder){
            return response()->json([
                        'success' => false,
                        'message' => "File category cannot be found."
                    ]); 
        }

        $new_folder_name = $folder->name.'_copy';
        $nf = Folder::where('name', $new_folder_name)->where('parent_id', $folder->parent_id)->first();
        if($nf){

            return response()->json([
                        'success' => false,
                        'message' => "A folder with the name \"".$new_folder_name."\" already exist in this category/folder. Please change the name of the existing folder before you create a new duplicate."
                    ]); 

        }
        // duplicating parent folders and files...
        $nf = Folder::create([
                        'name'          => $new_folder_name,
                        'parent_id'     => $folder->parent_id,
                        'workflow_id'   => $folder->workflow_id,
                        'colour'        => $folder->colour,
                        'description'   => $folder->description,
                        'is_locked'     => $folder->is_locked,
                        'created_by'    => Auth::user()->id  
                    ]);
        //folder fields
        $folderFields = $folder->fields()->pluck('id')->toArray();
        $nf->fields()->sync($folderFields);

        if( $this->duplicateInnerFolders($folder, $nf) ){

            log_action(Auth::id(), 'Duplicated Folder', 'App\Models\Folder', $folder->id, 'File category "'.$new_folder_name.'" was created as a duplicate.');


            return response()->json([
                    'success' => true,
                    'message' => $folder->name." has been duplicated successfully!"
                ]); 
        }

        else

            return response()->json([
                    'success' => false,
                    'message' => "File category has some files in it. The folder has to be empty before it can be removed!"
                ]); 

    
        
    }

    private function duplicateInnerFolders($oldFolder, $newFolder){

        foreach ($oldFolder->children()->get() as $childFolder) {
            
            $nf = Folder::create([
                        'name'          => $childFolder->name,
                        'parent_id'     => $newFolder->id,
                        'workflow_id'   => $newFolder->workflow_id,
                        'colour'        => $childFolder->colour,
                        'description'   => $childFolder->description,
                        'is_locked'     => $childFolder->is_locked,
                        'created_by'    => Auth::user()->id  
                    ]);
            $folderFields = $childFolder->fields()->pluck('id')->toArray();
            $nf->fields()->sync($folderFields);


            $this->duplicateInnerFolders($childFolder, $nf);
        }

        return true;
    }



    public function getFileCount(Request $request)
    {
        
        $folder = Folder::find($request->folder_id);

        if(!$folder){
            return response()->json([
                        'success' => false,
                        'message' => "File category cannot be found."
                    ]); 
        }

        // dump($folder->id);
        $fileCount = $this->getFilesInFolderCount($folder->id);

        return response()->json([
                    'success' => true,
                    'message' => number_format($fileCount)
                ]); 
        
        
    }

    private function getFilesInFolderCount($folderId){

        $fileCount = 0;
        $folder = Folder::withCount('files')->find($folderId);
        $fileCount += $folder->files_count;
        foreach ($folder->children()->get() as $child) {
            $fileCount += $this->getFilesInFolderCount($child->id);
        }

        return $fileCount;
    }

    public function followFile(Request $request)
    {
        $file = File::find($request->file_id);

        $attributes = ['is_following' => 1];

        $file->users()->updateExistingPivot(Auth::user()->id, $attributes);
        log_action(Auth::id(), 'File Follow', 'App\Models\File', $file->id, ' started following file: '.$file->name);
        
        return redirect()->back()->with('success', 'You are now following File: '.$file->name);
    }

    public function unfollowFile(Request $request)
    {
        $file = File::find($request->file_id);

        $attributes = ['is_following' => 0];

        $file->users()->updateExistingPivot(Auth::user()->id, $attributes);
        log_action(Auth::id(), 'File Unfollow', 'App\Models\File', $file->id, ' started unfollowing file: '.$file->name);
        
        return redirect()->back()->with('success', 'You are now unfollowing File: '.$file->name);
    }

    public function backups(Request $request)
    {
        
        $mainTab = 'users';

        $backups = Backup::orderBy('created_at', 'desc')->get();

        return view('files.backups', compact('mainTab', 'backups'));
    }

    public function createBackup(){

        //checking if there is an ongoing backup process
        $b = Backup::where('status', 'ONGOING')->first();
        if($b){
            return response()->json([
                    'success' => false,
                    'message' => "There is an ongoing backup process. You have to either wait for it to finish or cancel it to run another backup."
                ]); 
        }


        $f_name = config('app.name').'-'.date('Y-m-d-H-i-s');
        

        //checking if temp_backup exist or make a directory
        if (!file_exists('temp_backup')) {
        \File::makeDirectory('temp_backup');
        }
        if (!file_exists('mxfs')) {
            \File::makeDirectory('mxfs');
        }

        $zip_file = 'temp_backup/uploads.zip';
        
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $path = public_path('uploads');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($files as $name => $file)
        {
           
            // We're skipping all subfolders
            if (!$file->isDir()) {
               
                $filePath   = $file->getRealPath();
                
                // extracting filename with substr/strlen
                $relativePath = 'uploads/' . substr($filePath, strlen($path) + 1);
                
                if(file_exists($filePath) && file_exists($relativePath)){
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
        
        $zip->close();

        // database dump    
        \Artisan::call('backup:run', ['--only-db'=>1]);

        //zipping both backups ... and moving it to backup folder
        $zip_file = ($f_name).'.mxf';
        $zip = new \ZipArchive();
        $zip->open('mxfs/'.$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        
        $path = public_path('temp_backup');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                // echo($filePath);

                // extracting filename with substr/strlen
                $relativePath = 'temp_backup/' . substr($filePath, strlen($path) + 1);
                // echo ($relativePath );

                $zip->addFile($filePath, $relativePath);
            }
        }
        
        $zip->close();

        \File::deleteDirectory('temp_backup');
        
        //removing temp_files
        


        //movng backup to storage
        // \Fil::


        //completing backup
        $b = Backup::firstOrCreate([
                    'name' => $f_name,
                    'file' => '',
                    'created_by'  => Auth::user()->id,
                    'status'      => 'ONGOING'
            ]);
        $b->file    = $zip_file;
        $b->status  = 'COMPLETED';
        $b->save();

        
        return response()->json([
                    'success' => true,
                    'message' => "Backup Done."
                ]); 

        

    }


    public function cancelBackup(Request $request){

        //checking if there is an ongoing backup process
        $b = Backup::find($request->backup_id);
        if(!$b){
            return response()->json([
                    'success' => false,
                    'message' => "Backup cannot be found."
                ]); 
        }

        if($b->status != 'ONGOING'){
            return response()->json([
                    'success' => false,
                    'message' => "Backup cannot be cancelled. It is already completed."
                ]); 
        }

        //remove temp files...
        // dump(Storage::disk('public')->files('temp_backup'));
        \File::deleteDirectory('temp_backup');


        $b->delete();
        
        
        
        return response()->json([
                    'success' => true,
                    'message' => "Backup cancelled."
                ]); 

        

    }

    public function restoreBackup(Request $request){

        //checking if there is an ongoing backup process
        $b = Backup::find($request->backup_id);
        if(!$b){
            return response()->json([
                    'success' => false,
                    'message' => "Backup cannot be found."
                ]); 
        }

        if($b->status == 'ONGOING'){
            return response()->json([
                    'success' => false,
                    'message' => "Only a completed backup can be restored."
                ]); 
        }


        //extracting the zip
        $zip = new \ZipArchive();
        $zip->open('mxfs/'.$b->file);
        $zip->extractTo('extracted');      
        $zip->close();
        

        //extracting the upload folder
        $zip = new \ZipArchive();
        $zip->open('extracted/temp_backup/uploads.zip');
        $zip->extractTo('extracted');
        $zip->close();

        // moving uploads folder to the right place
        \File::deleteDirectory('uploads');
        \File::move('extracted/uploads', 'uploads');


        //extracting the db file
        $db_name = str_ireplace(config('app.name').'-', '', $b->name).'.zip';
        // dump($db_name);
        $ff = \File::files('extracted/temp_backup/'.config('app.name'))[0];
        // dump($ff->getPathname());

        $zip = new \ZipArchive();
        // $ff->getPathname();
        $zip->open($ff->getPathname());
        $zip->setPassword(env('APP_PS'));  
        // if($zip->extractTo('extracted/db-dumps')){
        //     echo 'extracted';
        // }else echo 'nope';
        $zip->extractTo('extracted/db-dumps');
        $zip->setPassword('Maxtech2018');
        $zip->close();
        
        $zip = new \ZipArchive();
        $zip->open('extracted/db-dumps/backup.zip');
        $zip->extractTo('extracted');
        $zip->close();

        $zip = new \ZipArchive();
        $zip->open('extracted/db-dumps/backup.zip');
        $zip->extractTo('extracted/db');
        $zip->close();
        DB::unprepared(file_get_contents('extracted/db/db-dumps/mysql-'.env('DB_DATABASE').'.sql'));


        \File::deleteDirectory('extracted/db');
        \File::deleteDirectory('extracted/temp_backup');
        \File::deleteDirectory('extracted/db-dumps');
        \File::deleteDirectory('extracted/uploads');
        


        // $b->delete();
        
        
        
        return response()->json([
                    'success' => true,
                    'message' => "Backup restored."
                ]); 

        

    }

    private function getFileId() {
        $fileId = DB::table('files')->orderBy('id', 'desc')->first();
        
        if(!$fileId){
            return 1;
        }
        return $fileId->id +1;
    }


}
