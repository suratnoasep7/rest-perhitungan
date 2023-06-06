<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page;

        if ($request->page == "") {
            $skip = 0;
        }
        else {
            $skip = $perPage * $request->page;
        }
        //get data from table note
        $note = Note::skip($skip)->paginate($perPage);

        //make response JSON
        return response()->json($note, 200);

    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find note by ID
        $note = Note::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Note',
            'data'    => $note 
        ], 200);

    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $note = Note::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //success save to database
        if($note) {

            return response()->json([
                'success' => true,
                'message' => 'Note Created',
                'data'    => $note  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Note Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find note by ID
        $note = Note::findOrFail($note->id);

        if($note) {

            //update note
            $note->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note Updated',
                'data'    => $note  
            ], 200);

        }

        //data note not found
        return response()->json([
            'success' => false,
            'message' => 'Note Not Found',
        ], 404);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find note by ID
        $note = Note::findOrfail($id);

        if($note) {

            //delete note
            $note->delete();

            return response()->json([
                'success' => true,
                'message' => 'Note Deleted',
            ], 200);

        }

        //data note not found
        return response()->json([
            'success' => false,
            'message' => 'Note Not Found',
        ], 404);
    }
}
