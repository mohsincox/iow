<?php

namespace App\Http\Controllers;

    use App\Recipe;
    use App\Test;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Intervention\Image\ImageManagerStatic as Image;
use Validator;
class RecipeController extends Controller
{
     public function make_slug($string) {
        return preg_replace('/\s+/u', '-', trim($string));
    }
   /*
    * create_recipe
    */
   public function create_recipe(Request $request){
       if ($request->isMethod('post')){
           $data = $request->all();
         $validator = Validator::make($data, [
               'blog_type' =>'required',
               'short_des' => 'required',
               'image' => 'required',
               'title' => 'required',
               'des' => 'required',
           ]);
           if ($validator->fails()) {
               return redirect()->back()
                   ->withErrors($validator)
                   ->withInput();
           }
         if ($request->hasFile('image')) {

             $validator = Validator::make($request->all(), [
               'image' => 'mimes:jpeg,bmp,png,jpg,gif'
             ]);
             if ($validator->fails()) {
               return redirect()->back()
                 ->withErrors($validator)
                 ->withInput();
             }

           $id = 0;
           $image = $request->file('image');
           $image2 = $request->file('image');
           $name = time().$id.'.'.$image->getClientOriginalExtension();
           $path = 'recipe_images/';
           $destinationPath = public_path($path);
           ++$id;
           $name2 = time().$id.'.'.$image2->getClientOriginalExtension();
           $path2 = 'recipe_images/';
           $destinationPath2 = public_path($path2);
           $image_resize = Image::make($image2->getRealPath());
//               $image_resize->resize(552, 221);
           $image_resize->resize(380, null, function ($constraint) {
                 $constraint->aspectRatio();
               });
           $image_resize->save($destinationPath2. $name2);

           $image->move($destinationPath, $name);
           }
           $recipe_image = '';
           if(isset($name)){
               $recipe_image = $path.$name;
           }
           $thum_image = "";
           if(isset($name2)){
             $thum_image = $path2.$name2;
           }
           $recipe = New Recipe();
           $recipe->blog_type = $data['blog_type'];
           $recipe->title = $data['title'];
           $recipe->short_des = $data['short_des'];
           $recipe->des = $data['des'];
           $recipe->image = $recipe_image;
           $recipe->thumbnail_image = $thum_image;
           $recipe->slug = $this->make_slug($data['title']);
           $recipe->status ='Publish';
           if ($recipe->save()){
               $status = '<div class="alert alert-success alert-dismissible" role="alert">
                                <strong> '. $data['title'] .'  </strong>Recipe Successfully Added.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
               return redirect()->back()->with('status', $status);
           }else{
               $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong> '. $data['title'] .' </strong>Recipe Not  Added !! Try Again.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
               return redirect()->back()->with('status', $status);
           }


       }
       return view('admin.recipe.create_new');
   }
   /*
    * view_recipe
    */
   public function view_recipe(){
       $recipes = Recipe::whereNull('deleted_at')->orderBy('id', "DESC")->get();
       return view('admin.recipe.view_recipe',compact('recipes'));
   }
   /*
    * view_recipe
    */
   public function edit_recipe(Request $request, $slug){
       $recipe = Recipe::where('slug', '=', $slug)->get();
       if(count($recipe) > 0){
           $recipe = $recipe[0];
           if($request->isMethod("POST")){
//             return $request;
               $data = $request->all();
               $validator = Validator::make($data, [
                   'blog_type' =>'required',
                   'short_des' =>'required',
                   'title' => 'required',
                   'des' => 'required',
               ]);

               if ($validator->fails()) {
                   return redirect()->back()
                       ->withErrors($validator)
                       ->withInput();
               }


               if ($request->hasFile('image')) {

                 $validator = Validator::make($request->all(), [
                   'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                 ]);
                 if ($validator->fails()) {
                   return redirect()->back()
                     ->withErrors($validator)
                     ->withInput();
                 }


                   $id = 0;
                   $image = $request->file('image');
                   $name = time().$id.'.'.$image->getClientOriginalExtension();
                   $path = 'recipe_images/';
                   $destinationPath = public_path($path);
                   ++$id;


                   $image2 = $request->file('image');
                   $name2 = time().$id.'.'.$image2->getClientOriginalExtension();
                   $path2 = 'recipe_images/';
                   $destinationPath2 = public_path($path2);
                   $image_resize = Image::make($image2->getRealPath());
//                   $image_resize->resize(552, 221);
                   $image_resize->resize(380, null, function ($constraint) {
                     $constraint->aspectRatio();
                   });
                   $image_resize->save($destinationPath2. $name2);


                   $image->move($destinationPath, $name);
               }

               if(isset($name,$name2)){
                   $recipe_image = $path.$name;
                   $thum_image = $path2.$name2;
                   $data_new = [
                       'blog_type' => $data['blog_type'],
                       'title' => $data['title'],
                       'des' => $data['des'],
                       'short_des' => $data['short_des'],
                       'image' => $recipe_image,
                       'thumbnail_image' => $thum_image,
                       'status' => $data['status'],
                   ];
               } else{
                   $data_new = [
                       'blog_type' => $data['blog_type'],
                       'title' => $data['title'],
                       'short_des' => $data['short_des'],
                       'des' => $data['des'],
                       'status' => $data['status'],
                   ];
               }

               $result = Recipe::where('slug', '=', $recipe->slug)->update($data_new);
               if ($result) {
             //              deleting image
                   $old_recipe_image_path = public_path($recipe->image);
                   if (file_exists($old_recipe_image_path) && isset($recipe_image)) {
                     @unlink($old_recipe_image_path);
                   }
                   $old_thum_image_path = public_path($recipe->thumbnail_image);
                   if (file_exists($old_thum_image_path) && isset($thum_image)) {
                     @unlink($old_thum_image_path);
                   }



                   $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong>' . $data['title'] . '</strong>Recipe successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                   return redirect()->route('admin.view-recipe')->with('status', $status);
               } else {
                   $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                   return redirect()->back()->with('status', $status)->withInput();
               }
           }
           return view('admin.recipe.edit_recipe')->with('recipe', $recipe);
       }
       return redirect()->route('404');
   }
   /*
    * view_recipe
    */
   public function delete_recipe(Request $request){
       if($request->isMethod("POST")) {
           if(Recipe::where('id', '=', $request->post('id'))->delete()){
               return "success";
           }
       }
   }



//   /**
//     * test for slug
//     */

//   public function test(Request $request){

//       if ($request->isMethod('post')){
//           $post = new Test();
//           $post->name = $request->post('name');
//           $post->save();
//       }

//       $rescent = Test::select('slug')->latest('updated_at', 'desc')->first();
// //       return $rescent;
//       return view('test',compact('rescent'));
//   }
}

