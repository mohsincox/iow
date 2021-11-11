<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\GalleryTitleHasImage;
use SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;


class GalleryController extends Controller
{

    #find array keys
    function findKey($array, $keySearch) {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            } elseif (is_array($item) && $this->findKey($item, $keySearch)) {
                return true;
            }
        }
        return false;
    }
    /*
     *
     * adding gallery by admin in gallery and galery_title_has_image table
     * */
    public function add_gallery_by_admin(Request $request){
        if($request->isMethod("POST")){
            $data = $request->all();
            $validator = Validator::make($data, [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $images=array();
            if ($request->hasFile('image')) {
              if ($files = $request->file('image')) {
//              multiple image type validation
                foreach ($files as $file) {
                  $image = ['image' => $file];
                  $validator = Validator::make($image, [
                    'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                  ]);
                  if ($validator->fails()) {
                    return redirect()->back()
                      ->withErrors($validator)
                      ->withInput();
                  }
                }


                $i = 0;
                foreach ($files as $file) {
                    $i++;
                    $name = time().$i.'.'.$file->getClientOriginalExtension();
                    $path = 'gallery_images/';
                    $destinationPath = public_path($path);
                    $file->move($destinationPath, $name);

//                        $image_resize = Image::make($file->getRealPath());
//                        $image_resize->resize(800, 500);

//                        $file->move($destinationPath, $name);
                    $images[] = $path.$name;
                }
              }
            }
            $galleryTitle = new Gallery();
            $galleryTitle->title = $request->post('title');
            if($galleryTitle->save()){
                foreach ($images As $val){
                    GalleryTitleHasImage::create([
                        'title_id' => $galleryTitle->id,
                        'image' => $val,
                    ]);
                }
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Gallery successfully added. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }
            $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Something went wrong. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status)->withInput();
        }
        return view('admin.gallery.add_gallery');
    }
    /*
     *
     * view gallery by admin
     * */
    public function view_gallery_by_admin(){
//        $galleryTitle=Gallery::whereNull('deleted_at')->get();
//        $galleryTitelHasImage = GalleryTitleHasImage::whereNull('deleted_at')->get();
        $data = DB::table('galleries')
            ->leftJoin('gallery_title_has_image', 'gallery_title_has_image.title_id', '=', 'galleries.id')
            ->select('galleries.title', 'gallery_title_has_image.*')
            ->whereNull('gallery_title_has_image.deleted_at')
            ->whereNull('galleries.deleted_at')
            ->get();
        $galleris=[];
        foreach ($data As $key => $value){
            if(!$this->findKey($galleris, $value->title_id)){
                $galleris[$value->title_id] = [
                  'title_id' => $value->title_id,
                  'title' => $value->title,
                  'image_id' => $value->id,
                  'image' => $value->image,
                ];
            }
        }
        return view('admin.gallery.view_gallery', compact('galleris'));
    }
    /*
     * admin will edit gallery
     * */
    public function edit_gallery_by_admin(Request $request, $title_id){
        $galleryTitle=Gallery::whereNull('deleted_at')->where('id', '=', $title_id)->get();
        if(count($galleryTitle) > 0 ) {
            $galleryTitle = $galleryTitle[0];
            $galleryTitelHasImage = GalleryTitleHasImage::whereNull('deleted_at')->where('title_id','=', $title_id)->get();

            if($request->isMethod("POST")) {
//                return $request;
                $data = $request->all();
                $validator = Validator::make($data, [
                    'title' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $images = array();
                if ($request->hasFile('image')) {
                    if ($files = $request->file('image')) {
//                 multiple image type validation
                      foreach ($files as $file) {
                        $image = ['image' => $file];
                        $validator = Validator::make($image, [
                          'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                        ]);
                        if ($validator->fails()) {
                          return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
                        }
                      }


                      $i = 0;
                      foreach ($files as $file) {
                          $i++;
                          $name = time() . $i . '.' . $file->getClientOriginalExtension();
                          $path = 'gallery_images/';
                          $destinationPath = public_path($path);
                          $file->move($destinationPath, $name);

//                            $image_resize = Image::make($file->getRealPath());
//                            $image_resize->resize(800, 500);
//                            $file->move($destinationPath, $name);


                          $images[] = $path . $name;
                      }
                    }
                }
                $title = $request->post("title");
                if (Gallery::whereNull('deleted_at')->where('id', '=', $title_id)->update(['title' => $title])) {
                    foreach ($images As $val) {
                        GalleryTitleHasImage::create([
                            'title_id' => $title_id,
                            'image' => $val,
                        ]);
                    }
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Gallery successfully Updated. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->route('admin.view-gallery')->with('status', $status);
                } else {
                    $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Something went wrong. 
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('admin.gallery.edit_gallery', compact('galleryTitle', 'galleryTitelHasImage'));
        }
        $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Gallery not found. 
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
        return redirect()->route('admin.view-gallery')->with('status', $status);
    }
    /*
     * admin will delete products
     * */
    public function delete_gallery_by_admin(Request $request){
        if($request->isMethod("POST")) {
            $id = $request->post('id');
            if(Gallery::where('id', '=', $id)->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }
    /*
     * admin will delete products image
     * */
    public function delete_gallery_image_by_admin(Request $request){
        if($request->isMethod("POST")) {
            $image = $request->post('image');
            $product_id = $request->post('image_id');
            if(GalleryTitleHasImage::where('id', '=', $product_id)->where('image', '=', $image)->delete()){
//            deleting image
              $old_image_path = public_path($image);
              if (file_exists($old_image_path)) {
                @unlink($old_image_path);
              }
              return "success";
            }
        }
    }
    /**
     * igloo_gallery
     */
    public function igloo_gallery(){
      SEO::setTitle('Galleries');
//      SEO::setDescription('A world of great test!');
        $galleries = DB::table('galleries')
            ->leftJoin('gallery_title_has_image', 'gallery_title_has_image.title_id', '=', 'galleries.id')
            ->select('galleries.title', 'galleries.id', DB::raw('group_concat(gallery_title_has_image.image) as image'))
            ->whereNull('gallery_title_has_image.deleted_at')
            ->whereNull('galleries.deleted_at')
            ->groupBy('galleries.id')
            ->orderBy('galleries.id', 'desc')
            ->get();
        return view('site.gallery', compact('galleries'));
    }
    /** igloo_gallery */
    public function single_igloo_gallery($gallery_id){
        $galleries = DB::table('galleries')
            ->leftJoin('gallery_title_has_image','gallery_title_has_image.title_id', '=', 'galleries.id')
            ->select('galleries.title', 'galleries.id', DB::raw('group_concat(gallery_title_has_image.image) as image'))
            ->whereNull('gallery_title_has_image.deleted_at')
            ->whereNull('galleries.deleted_at')
            ->where('galleries.id', '=', $gallery_id)
            ->groupBy('galleries.id')
            ->orderBy('galleries.id', 'desc')
            ->get();
        if(count($galleries) > 0){
            $galleries = $galleries[0];
          SEO::setTitle($galleries->title);
  //      SEO::setDescription('A world of great test!');
          return view('site.single_gallery')->with('gallery', $galleries);
        }else{
            $galleries = null;
        }
    }
}
