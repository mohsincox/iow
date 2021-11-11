<?php

namespace App\Http\Controllers;

use App\Career;
use App\Contact;
use App\PrivacyPolicy;
use App\Slider;
use App\TermsCondition;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Expr\New_;
use Validator;

class CmsController extends Controller
{
    /*
     * slider add
     */
    public function create_slider(Request $request){
        if ($request->isMethod('post')){
            $data=$request->all();
            $validator = Validator::make($data, [
                'image' => 'required|mimes:jpeg,bmp,png,jpg,gif',

            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $path = '/slider_image/';
                $destinationPath = public_path($path);
                $image->move($destinationPath, $name);
            }
            $slider_image = '';
            if(isset($name)){
                $slider_image = $path.$name;
            }
            $slide = new Slider;
            $slide->title= $data['title'];
            $slide->image= $slider_image;
            $slide->des= $data['des'];
//            $slide->overly_color= $data['overly_color'];
            $slide->btn_name= $data['btn_name'];
            $slide->btn_link= $data['btn_link'];
            if ($slide->save()){
                $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Slide successfully Added.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }else{
                $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.slider.create_slider');
    }
    /*
     * slider edit
     */
    public  function edit_slider(Request $request, $id){
        $slide= Slider::where('id',$id)->get();
//        return $slide;
        if(count($slide) > 0){
            $slide= $slide[0];
            if ($request->isMethod('post')){
                $data = $request->all();
                if ($request->hasFile('image')) {
                  $validator = Validator::make($request->all(), [
                    'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                  ]);
                  if ($validator->fails()) {
                    return redirect()->back()
                      ->withErrors($validator)
                      ->withInput();
                  }
                    $image = $request->file('image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $path = '/slider_image/';
                    $destinationPath = public_path($path);
                    $image->move($destinationPath, $name);
                }
                $slider_image = '';
                if(isset($name)){
                    $slider_image = $path.$name;
                    $data_new = [
                        'title' => $data['title'],
                        'des' => $data['des'],
                        'image' => $slider_image,
//                        'overly_color' => $data['overly_color'],
                        'btn_name' => $data['btn_name'],
                        'btn_link' => $data['btn_link'],
                    ];
                }else{
                    $data_new = [
                        'title' => $data['title'],
                        'des' => $data['des'],
//                        'overly_color' => $data['overly_color'],
                        'btn_name' => $data['btn_name'],
                        'btn_link' => $data['btn_link'],
                    ];
                }
                $result = Slider::where('id', '=', $slide->id)->update($data_new);
                if ($result) {
//              deleting image
                  $old_image_path = public_path($slide->image);
                  if (file_exists($old_image_path)) {
                    @unlink($old_image_path);
                  }

                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong>' . $data['title'] . ' </strong>Slide successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->route('admin.view-slider')->with('status', $status);
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
        }
        return view('admin.slider.edit_slider',compact('slide'));

    }
    /*
     * slider delete
     */
    public  function delete_slider(Request $request){
        if($request->isMethod("POST")) {
            if(Slider::where('id', '=', $request->post('id'))->delete()){
                return "success";
            }
        }
    }
    /*
     * slider view
     */
    public function view_slider(){
        $sliders = Slider::whereNull('deleted_at')->get();
        return view('admin.slider.view_slider',compact('sliders'));
    }
    /*
     * Career
     */
    public function career(Request $request){
        $career = Career::first();
        if ($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'editordata' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $career = Career::first();
            if ($career != null){
                $career->des = $data['editordata'];
                if ($career->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Career  successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }else{
                $privact_add = new Career();
                $privact_add->des = $data['editordata'];
                if ($privact_add->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Career successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
        }
        return view('admin.cms.career',compact('career'));
    }
    /*
     * about us
     */
    public function about_us(Request $request){
        if ($request->isMethod('post')){

            return $request;
        }
        return view('admin.cms.about_us');
    }
    /*
     * contact us
     */
    public function contact_us(Request $request){
        $contact = Contact::first();
        if ($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'address' => 'required',
                'email' => 'required',
                'mobile_no' => 'required',
                'telephone_no' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $contact = Contact::first();
            if ($contact != null){
                $contact->address = $data['address'];
                $contact->email = $data['email'];
                $contact->mobile_no = $data['mobile_no'];
                $contact->telephone_no = $data['telephone_no'];
                if ($contact->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Contact successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }else{
                $contact_add = new Contact();
                $contact_add->address = $data['address'];
                $contact_add->email = $data['email'];
                $contact_add->mobile_no = $data['mobile_no'];
                $contact_add->telephone_no = $data['telephone_no'];
                if ($contact_add->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Contact successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }

        }
        return view('admin.cms.contact_us',compact('contact'));
    }
    /*
     * privacy policy
     */
    public function privacy_policy(Request $request){
        $privacy = PrivacyPolicy::first();
        if ($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'editordata' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $privacy = PrivacyPolicy::first();
            if ($privacy != null){
                $privacy->des = $data['editordata'];
                if ($privacy->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Privacy & policy successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }else{
                $privact_add = new PrivacyPolicy();
                $privact_add->des = $data['editordata'];
                if ($privact_add->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Privacy & policy successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }

        }
        return view('admin.cms.privacy_policy',compact('privacy'));
    }
    /*
     * privacy policy
     */
    public function terms_condition(Request $request){
        $terms = TermsCondition::first();
        if ($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'editordata' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $privacy = TermsCondition::first();
            if ($privacy != null){
                $privacy->des = $data['editordata'];
                if ($privacy->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Terms & Condition successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }else{
                $privact_add = new TermsCondition();
                $privact_add->des = $data['editordata'];
                if ($privact_add->save()){
                    $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong></strong>Terms & Condition successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }

        }
        return view('admin.cms.term_condition',compact('terms'));
    }
}
