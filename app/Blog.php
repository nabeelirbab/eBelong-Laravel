<?php

/**
 * Class Cource.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App;

use Auth;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Class Service
 *
 */
class Blog extends Model
{
    /**
     * Get all of the categories for the service.
     *
     * @return relation
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'catable');
    }

    /**
     * Get all of the languages for the service.
     *
     * @return relation
     */
    
    public function reports()
    {
        return $this->morphMany('App\Report', 'reportable');
    }

    /**
     * The users that belong to the service.
     *
     * @return relation
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

 

    public function skills()
    {

        return $this->belongsToMany('App\Skill')->withPivot('skill_rating');
    }

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!Blog::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Blog::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * Store service.
     *
     * @param mixed $request request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function storeBlog($request, $image_size = array())
    {   
        $json = array();
        if (!empty($request)) {
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            if ($role === 'editor'){
            $user_id=Auth::user()->id;
            $this->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);  
            $this->content = $request['content'];
            $this->editor_id = Auth::user()->id;
            $blog_attachments = array();
            
            $this->save();
            $blog_id = $this->id;
            $blog = Blog::find($blog_id);
            $old_path = Helper::PublicPath() . '/uploads/blogs/temp';
            $new_path = Helper::PublicPath() . '/uploads/blogs/' . $blog_id;
            if (!empty($request['attachments'])) {
                $attachments = $request['attachments'];
                foreach ($attachments as $key => $attachment) {
                    if (file_exists($old_path . '/' . $attachment)) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, 0755, true, true);
                        }
                        $filename = time() . '-' . $attachment;
                        if (!empty($image_size)) {
                            foreach ($image_size as $size) {
                                rename($old_path . '/' . $size . '-' . $attachment, $new_path . '/' . $size . '-' . $filename);
                            }
                            rename($old_path . '/' . $attachment, $new_path . '/' . $filename);
                        } else {
                            rename($old_path . '/' . $attachment, $new_path . '/' . $filename);
                        }
                        $blog_attachments[] = $filename;
                    }
                }
                $blog->attachments = serialize($blog_attachments);
                $blog->save();
            }
            $categories = $request['categories'];
            $blog->categories()->sync($categories);
            if ($request['skills']) {
                $skills = $request['skills'];
                foreach ($skills as $skill) {
                    $blog->skills()->attach($skill['id'],['skill_rating' => $skill['rating']]);
                }
            }
            // $cource->skills()->attach($request['skills']);
           
            $json['new_blog'] = $blog_id;
            $json['type'] = 'success';
            return $json;
        }
        else{
            $json['type'] = 'blog_warning';
            return $json;
        }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Update Jobs.
     *
     * @param mixed   $request request
     * @param integer $id      ID
     *
     * @return $request, ID
     */
    public function updateBlog($request, $id, $image_size = array())
    {
        $json = array();
        if (!empty($request)) {
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            if ($role === 'editor'){
            $blog = Blog::find($id);
            $user_id=Auth::user()->id;
            if ($blog->title != $request['title']) {
                $blog->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            }
            $blog->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $blog->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);  
            $blog->content = $request['content'];
            $blog->editor_id = Auth::user()->id;
            $blog_attachments = array();
            $old_path = Helper::PublicPath() . '/uploads/blogs/temp';
            $new_path = Helper::PublicPath() . '/uploads/blogs/' . $id;
            if (!empty($request['attachments'])) {
                $attachments = $request['attachments'];
                foreach ($attachments as $key => $attachment) {
                    if (file_exists($old_path . '/' . $attachment)) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, 0755, true, true);
                        }
                        $filename = time() . '-' . $attachment;
                        if (!empty($image_size)) {
                            foreach ($image_size as $size) {
                                rename($old_path . '/' . $size . '-' . $attachment, $new_path . '/' . $size . '-' . $filename);
                            }
                            rename($old_path . '/' . $attachment, $new_path . '/' . $filename);
                        } else {
                            rename($old_path . '/' . $attachment, $new_path . '/' . $filename);
                        }
                        $blog_attachments[] = $filename;
                    }
                    else {
                        $blog_attachments[] = $attachment;
                    }
                }
                $blog->attachments = serialize($blog_attachments);
               
            }

            $blog->save();
            $blog_id = $id;
            $blog = Blog::find($blog_id);
            $categories = $request['categories'];
            $blog->categories()->sync($categories);
            if ($request['skills']) {
                $skills = $request['skills'];
                $blog->skills()->detach();
                if (!empty($skills)) {
                    foreach ($skills as $skill) {
                        $blog->skills()->attach($skill['id'],['skill_rating' => $skill['rating']]);
                    }
                }
            }
            // $cource->skills()->attach($request['skills']);
           
            $json['new_blog'] = $blog_id;
            $json['type'] = 'success';
            return $json;
        }
        else{
            $json['type'] = 'blog_warning';
            return $json;
        }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    
    public static function getSearchResult(
        $keyword,
        $search_categories,
        $search_skills
    ) {
        $json = array();
        $blogs = Blog::select('*')->where('status','published')->orderBy('id','DESC');
        $blog_id = array();
        $filters = array();
        $filters['type'] = 'blogs';
        if (!empty($keyword)) {
            $filters['s'] = $keyword;
            $blogs->where('title', 'like', '%' . $keyword . '%')->where('status','published')->get();
        };
        if (!empty($search_categories)) {
            $filters['category'] = $search_categories;
            foreach ($search_categories as $key => $search_category) {
                $categor_obj = Category::where('slug', $search_category)->first();
                $category = Category::find($categor_obj->id);
               
                if (!empty($category->blogs)) {
                    $category_blogs = $category->blogs->pluck('id')->toArray();
                    foreach ($category_blogs as $id) {
                        $blog_id[] = $id;
                    }
                }
            }
            $blogs->where('status','published')->whereIn('id', $blog_id);
        }
        if (!empty($search_skills)) {
            $filters['skills'] = $search_skills;
            foreach ($search_skills as $key => $search_skill) {
                $skill_obj = Skill::where('slug', $search_skill)->first();
                $skill= Skill::find($skill_obj->id);
                if (!empty($skill->blogs)) {
                    $skill_blogs = $skill->blogs->pluck('id')->toArray();
                    foreach ($skill_blogs as $id) {
                        $blog_id[] = $id;
                    }
                }
            }
            $blogs->where('status','published')->whereIn('id', $blog_id);
        }
       
        $blogs= $blogs->orderByRaw("updated_at DESC")->paginate(20)->setPath('');
        foreach ($filters as $key => $filter) {
            $pagination = $blogs->appends(
                array(
                    $key => $filter,
                )
            );
        }
        $json['blogs'] = $blogs;
        return $json;
    }
}
