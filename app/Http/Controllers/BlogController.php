<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use App\Category;
use App\Location;
use App\Blog;
use App\Helper;
use App\Skill;
use App\SiteManagement;
use Auth;

class BlogController extends Controller
{
    /*
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $skill
     */
    protected $blog;

    /**
     * Create a new controller instance.
     *
     * @param instance $skill instance
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }
    public function create()
    {
        $languages = Language::pluck('title', 'id');
        $locations = Location::pluck('title', 'id');
        $categories = Category::pluck('title', 'id');
        if (file_exists(resource_path('views/back-end/editor/blogs/create.blade.php'))) {
            return view(
                'back-end.editor.blogs.create',
                compact(
                    'languages',
                    'categories')
            );
        } 
    }

    public function getBlogSkills(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            // $course = $this->cource::where('slug', $request['slug'])->select('id')->first();
            
                $blog = $this->blog::find($request['id']);
                if (!empty($blog)) {
                $skills = $blog->skills->toArray();
                if (!empty($skills)) {
                    $json['type'] = 'success';
                    $json['skills'] = $skills;
                    return $json;
                } else {
                    $json['error'] = 'error';
                    return $json;
                }
            } else {
                $json['error'] = 'error';
                return $json;
            }
      }
    }

    public function store(Request $request)
    {
        
        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        
        $this->validate(
            $request,
            [
                'title' => 'required',
                'content' => 'required',
               
            ]
        );
        
        
            $image_size = array(
                'small',
                'medium'
            );
            $blog_post = $this->blog->storeBlog($request, $image_size);
            if ($blog_post['type'] == 'success') {
                $json['type'] = 'success';
                $json['progress'] = trans('lang.blog_publishing');
                $json['message'] = trans('lang.blog_post_success');
                return $json;
            } elseif ($blog_post['type'] == 'error') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.need_to_purchase_pkg');
                return $json;
            } elseif ($blog_post['type'] == 'blog_warning') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_authorize');
                return $json;
            }
    }

        public function uploadTempImage(Request $request)
        {
            if (!empty($request['file'])) {
                $attachments = $request['file'];
                $path = Helper::PublicPath() . '/uploads/blogs/temp/';
                $image_size = array(
                    'small' => array(
                        'width' => 80,
                        'height' => 80,
                    ),
                    'medium' => array(
                        'width' => 670,
                        'height' => 450,
                    ),
                );
                return Helper::uploadTempImageWithSize($path, $attachments, '', $image_size);
            }
        }
        public function show($slug)
        {
            $selected_blog = $this->blog::select('id')->where('slug', $slug)->first();
            if (!empty($selected_blog)) {
                $blog = $this->blog::find($selected_blog->id);
                $attachments = !empty($blog->attachments) ? Helper::getUnserializeData($blog->attachments) : '';
                // $service_reviews = DB::table('reviews')->where('job_id', $service->id)->get();
                $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
                $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
                $key = 'set_blog_view';
                if (!isset($_COOKIE[$key . $selected_blog->id])) {
                    setcookie($key . $selected_blog->id, $key, time() + 3600);
                    $view_key = $key;
                    $count = $blog->views;
                    if ($count == '') {
                        $count = 1;
                    } else {
                        $count++;
                    }
                    $blog->views = $count;
                    $blog->save();
                }
                if (!empty($blog)) {
                    // if (file_exists(resource_path('views/extend/front-end/blogs/show.blade.php'))) {
                    //     return view(
                    //         'extend.front-end.blogs.show',
                    //         compact(
                    //             'blog',
                    //             'attachments',
                    //             'show_breadcrumbs'
                    //         )
                    //     );
                    // } else {
                        return view(
                            'front-end.blogs.show',
                            compact(
                                'blog',
                                'attachments',
                                'show_breadcrumbs'
                            )
                        );
                    // }
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }
        public function manageBlogs(){
            
            $blogs = Blog::all();
            $status_list = array_pluck(Helper::getFreelancerServiceStatus(), 'title', 'value');
            if (file_exists(resource_path('views/extend/back-end/editor/blogs/index.blade.php'))) {
                return view(
                    'extend.back-end.editor.blogs.index',
                    compact(
                        'blogs',
                        'status_list'
                      
                    )
                );
            } else {
                return view(
                    'back-end.editor.blogs.index',
                    compact(
                        'blogs',
                        'status_list'  
                    )
                );
            }
        }

        public function editorBlogs(){

            $blogs = Blog::where('editor_id',Auth::user()->id)->get();
            $status_list = array_pluck(Helper::getFreelancerServiceStatus(), 'title', 'value');
            if (file_exists(resource_path('views/extend/back-end/editor/blogs/index.blade.php'))) {
                return view(
                    'extend.back-end.editor.blogs.index',
                    compact(
                        'blogs',
                        'status_list'
                    )
                );
            } else {
                return view(
                    'back-end.editor.blogs.index',
                    compact(
                        'blogs',
                        'status_list'
                    )
                );
            }

        }
        public function destroy(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $blog= $this->blog::find($request['id']);
            $blog->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.course_delete');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function edit($id)
    {
      
        $categories = Category::pluck('title', 'id');
        $blog = $this->blog::find($id);
        $serialize_attachment = preg_replace_callback(
            '!s:(\d+):"(.*?)";!',
            function ($match) {
                return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
            },
            $blog->attachments
        );
        $attachments = !empty($serialize_attachment) ? unserialize($serialize_attachment) : '';
        if (file_exists(resource_path('views/extend/back-end/editor/blogs/edit.blade.php'))) {
            return view(
                'extend.back-end.editor.blogs.edit',
                compact(
                    'categories',
                    'blogs',
                    'attachments'
                )
            );
        } else {
            return view(
                'back-end.editor.blogs.edit',
                compact(
                    'categories',
                    'blog',
                    'attachments',
                )
            );
        }
    }
    public function update(Request $request)
    {
        
        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        
        $this->validate(
            $request,
            [
                'title' => 'required',
                'content' => 'required'
               
            ]
        );
        
        
            $image_size = array(
                'small',
                'medium'
            );
            $id = $request['id'];
            $blog_post = $this->blog->updateBlog($request, $id,$image_size);
            if ($blog_post['type'] == 'success') {
                $json['type'] = 'success';
                $json['progress'] = trans('lang.blog_publishing');
                $json['message'] = trans('lang.blog_post_success');
                return $json;
            } elseif ($blog_post['type'] == 'error') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.need_to_purchase_pkg');
                return $json;
            } elseif ($blog_post['type'] == 'blog_warning') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_authorize');
                return $json;
            }
    }
    public function changeStatus(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
                $blog = $this->blog::find($request['id']);
                $blog->status = $request['status'];
                $blog->save();
                $json['type'] = 'success';
                $json['message'] = trans('lang.status_update');
                return $json;
            
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
       
    }
    public function bloglist($type,$slug){
        
        // $blogs = Blog::select('*')->where('status','published')->orderBy('id','DESC');
        $categories = Category::orderBy('title')->get();
        $skills     = Skill::orderBy('title')->get();
        $blog_id = array();
        $blogs= array();
        if($type=='category'){
            $categor_obj = Category::where('slug', $slug)->first();
            if(!empty($categor_obj->id)){
                $category = Category::find($categor_obj->id);
               
                if (!empty($category->blogs)) {
                    $category_blogs = $category->blogs->pluck('id')->toArray();
                    foreach ($category_blogs as $id) {
                        $blog_id[] = $id;
                    }
                }
                $blogs = Blog::where('status','published')->whereIn('id', $blog_id)->orderBy('id','DESC')->get();
            }
        }
        if($type='skill'){
                $skill_obj = Skill::where('slug', $slug)->first();
                if(!empty($skill_obj->id)){
                $skill= Skill::find($skill_obj->id);
                if (!empty($skill->blogs)) {
                    $skill_blogs = $skill->blogs->pluck('id')->toArray();
                    foreach ($skill_blogs as $id) {
                        $blog_id[] = $id;
                    }
                }
            
            $blogs=Blog::where('status','published')->whereIn('id', $blog_id)->orderBy('id','DESC')->get();
            }
        }
        $type = "Blogs";
        if (file_exists(resource_path('views/extend/front-end/blogs/blogList.blade.php'))) {
            return view(
                'extend.front-end.blogs.BlogList',
                compact(
                    'categories',
                    'skills',
                    'type',
                    'blogs',
                )
            );
        } else {
            return view(
                'front-end.blogs.blogList',
                compact(
                    'categories',
                    'skills',
                    'type',
                    'blogs',
                )
            );
        }
    }
    public function blogslist(){
        
        // $blogs = Blog::select('*')->where('status','published')->orderBy('id','DESC');
        $locations  = Location::all();
        $languages  = Language::all();
        $categories = Category::orderBy('title')->get();
        $skills     = Skill::orderBy('title')->get();
        $blog_id = array();
        $blogs= array();
        $blogs=Blog::where('status','published')->orderByRaw("updated_at DESC")->paginate(10)->setPath('');
        $type = "blogs";
        if (file_exists(resource_path('views/extend/front-end/blogs/blogList.blade.php'))) {
            return view(
                'extend.front-end.blogs.BlogList',
                compact(
                    'locations',
                    'languages',
                    'categories',
                    'skills',
                    'type',
                    'blogs',
                )
            );
        } else {
            return view(
                'front-end.blogs.blogList',
                compact(
                    'categories',
                    'skills',
                    'type',
                    'blogs',
                )
            );
        }
    }
 }


   


