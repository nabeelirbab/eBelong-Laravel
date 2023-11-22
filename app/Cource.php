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
class Cource extends Model
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
    public function languages()
    {
        return $this->morphToMany('App\Language', 'langable');
    }

    /**
     * Get the location that owns the service.
     *
     * @return relation
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get all of reported services.
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
        return $this->belongsToMany('App\User')->withPivot('type',  'seller_id', 'paid');
    }

    /**
     * Get service seller
     *
     * @return relation
     */
    public function seller()
    {
        return $this->belongsToMany('App\User')->wherePivot('type', 'seller', 'seller_id');
    }

    /**
     * Get service seller
     *
     * @return relation
     */
    public function purchaser()
    {
        return $this->belongsToMany('App\User')->wherePivot('type', 'employer', 'seller_id');
    }

    public function skills()

    {

        return $this->belongsToMany('App\Skill');
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
            if (!Cource::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Cource::all()->where('slug', $new_slug)->isEmpty()) {
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
    public function storeCource($request, $image_size = array())
    {
        $json = array();
        if (!empty($request)) {

            $random_number = Helper::generateRandomCode(8);
            $code = strtoupper($random_number);
            $user_id = Auth::user()->id;
            $location = $request['locations'];
            $this->location()->associate($location);
            $this->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->user_type = filter_var($request['user_type'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->price = filter_var($request['course_price'], FILTER_SANITIZE_STRING);
            $this->promotion_price  = filter_var($request['promotion_price'], FILTER_SANITIZE_STRING);
            $this->delivery_time_id = intval($request['delivery_time']);
            $this->description = $request['description'];
            $this->english_level = filter_var($request['english_level'], FILTER_SANITIZE_STRING);
            $this->response_time_id = intval($request['response_time']);
            $this->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $this->show_attachments = filter_var($request['show_attachments'], FILTER_SANITIZE_STRING);
            $this->address = filter_var($request['address'], FILTER_SANITIZE_STRING);
            $this->status = filter_var($request['status'], FILTER_SANITIZE_STRING);
            $this->course_date = filter_var($request['course_date'], FILTER_SANITIZE_STRING);
            $this->course_time = filter_var($request['course_time'], FILTER_SANITIZE_STRING);
            $this->longitude = filter_var($request['longitude'], FILTER_SANITIZE_STRING);
            $this->latitude = filter_var($request['latitude'], FILTER_SANITIZE_STRING);
            $this->additional_text = filter_var($request['additional_text'], FILTER_SANITIZE_STRING);
            $this->additional_text_bought = filter_var($request['additional_text_bought'], FILTER_SANITIZE_STRING);
            $old_path = Helper::PublicPath() . '/uploads/courses/temp';
            $new_path = Helper::PublicPath() . '/uploads/courses/' . $user_id;
            if ($request->hasFile('course_files')) {
                $file = $request->file('course_files');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = 'uploads/courses/temp';
                $path = $destinationPath . '/' . $filename;
                $file = $file->move($destinationPath, $filename);
                $this->course_files = $path;
            }
            if ($request->hasFile('course_files_bought')) {
                $file = $request->file('course_files_bought');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = 'uploads/courses/temp';
                $path = $destinationPath . '/' . $filename;
                $file = $file->move($destinationPath, $filename);
                $this->course_files_bought = $path;
            }
            $cource_attachments = array();
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
                        $cource_attachments[] = $filename;
                    }
                }
                $this->attachments = serialize($cource_attachments);
            }
            $this->code = $code;
            $this->save();
            $cource_id = $this->id;
            $cource = Cource::find($cource_id);
            $languages = $request['languages'];
            $cource->languages()->sync($languages);
            $categories = $request['categories'];
            $cource->categories()->sync($categories);
            if ($request['skills']) {
                $skills = $request['skills'];
                foreach ($skills as $skill) {
                    $cource->skills()->attach($skill['id']);
                }
            }
            // $cource->skills()->attach($request['skills']);
            $this->users()->attach($user_id, ['type' => 'seller', 'seller_id' => $user_id]);
            $json['new_cource'] = $cource_id;
            $json['type'] = 'success';
            return $json;
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
    public function updateCourse($request, $id, $image_size = array())
    {

        $json = array();
        if (!empty($request)) {
            $course = self::find($id);
            $random_number = Helper::generateRandomCode(8);
            $user_id = Helper::getCourceSeller($id);
            $location = $request['locations'];
            $course->location()->associate($location);
            if ($course->title != $request['title']) {
                $course->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            }
            $course->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $course->price = filter_var($request['course_price'], FILTER_SANITIZE_STRING);
            $course->promotion_price  = filter_var($request['promotion_price'], FILTER_SANITIZE_STRING);
            $course->delivery_time_id = intval($request['delivery_time']);
            $course->description = $request['description'];
            $course->english_level = filter_var($request['english_level'], FILTER_SANITIZE_STRING);
            $course->response_time_id = intval($request['response_time']);
            $course->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $course->show_attachments = filter_var($request['show_attachments'], FILTER_SANITIZE_STRING);
            $course->address = filter_var($request['address'], FILTER_SANITIZE_STRING);
            $course->course_date = filter_var($request['course_date'], FILTER_SANITIZE_STRING);
            $course->course_time = filter_var($request['course_time'], FILTER_SANITIZE_STRING);
            $course->longitude = filter_var($request['longitude'], FILTER_SANITIZE_STRING);
            $course->latitude = filter_var($request['latitude'], FILTER_SANITIZE_STRING);
            $course->additional_text = filter_var($request['additional_text'], FILTER_SANITIZE_STRING);
            $course->additional_text_bought = filter_var($request['additional_text_bought'], FILTER_SANITIZE_STRING);
            $old_path = Helper::PublicPath() . '/uploads/courses/temp';
            $new_path = Helper::PublicPath() . '/uploads/courses/' . $user_id->user_id;
            if ($request->hasFile('course_files')) {
                $file = $request->file('course_files');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = 'uploads/courses/temp';
                $path = $destinationPath . '/' . $filename;
                $file = $file->move($destinationPath, $filename);
                $course->course_files = $path;
            }
            if ($request->hasFile('course_files_bought')) {
                $file = $request->file('course_files_bought');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = 'uploads/courses/temp';
                $path = $destinationPath . '/' . $filename;
                $file = $file->move($destinationPath, $filename);
                $course->course_files_bought = $path;
            }
            $course_attachments = array();
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
                        $course_attachments[] = $filename;
                    } else {
                        $course_attachments[] = $attachment;
                    }
                }
                $course->attachments = serialize($course_attachments);
            }
            $course->save();
            $course_id = $course->id;
            $course = Cource::find($course_id);
            $languages = $request['languages'];
            $course->languages()->sync($languages);
            $categories = $request['categories'];
            $course->categories()->sync($categories);
            if ($request['skills']) {
                $skills = $request['skills'];
                $course->skills()->detach();
                if (!empty($skills)) {
                    foreach ($skills as $skill) {
                        $course->skills()->attach($skill['id']);
                    }
                }
            }
            $json['type'] = 'success';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Send Message.
     *
     * @param mixed $request request->attr
     * @param int   $user_id user_id
     *
     * @return response
     */

    /**
     * Send Message.
     *
     * @param mixed $request request->attr
     * @param int   $user_id user_id
     *
     * @return response
     */
    // public static function sendMessage($request, $user_id)
    // {
    //     if (!empty($request['recipent_id'])) {
    //         $message_attachments = array();
    //         if (!empty($request['attachments'])) {
    //             $old_path = 'uploads\courses\temp';
    //             $attachments = $request['attachments'];
    //             foreach ($attachments as $key => $attachment) {
    //                 if (Storage::disk('local')->exists($old_path . '/' . $attachment)) {
    //                     $new_path = 'uploads/courses/' . $user_id;
    //                     if (!file_exists($new_path)) {
    //                         File::makeDirectory($new_path, 0755, true, true);
    //                     }
    //                     $filename = time() . '-' . $attachment;
    //                     Storage::move($old_path . '/' . $attachment, $new_path . '/' . $filename);
    //                     $message_attachments[] = $filename;
    //                 }
    //             }
    //         }
    //         $msg_attachments = !empty($message_attachments) ? serialize($message_attachments) : null;
    //         DB::table('private_messages')->insert(
    //             [
    //                 'author_id' => $user_id, 'proposal_id' => $request['proposal_id'], 'content' => $request['description'],
    //                 'attachments' => $msg_attachments, 'project_type' => 'course',
    //                 'notify' => 0, "created_at" => \Carbon\Carbon::now(),
    //                 'updated_at' => \Carbon\Carbon::now(),
    //             ]
    //         );

    //         $lastInsertedID = DB::getPdo()->lastInsertId();
    //         DB::table('private_messages_to')->insert(
    //             [
    //                 'private_message_id' => $lastInsertedID, 'recipent_id' => $request['recipent_id'],
    //                 'message_read' => 0, 'read_date' => null, "created_at" => \Carbon\Carbon::now(),
    //                 'updated_at' => \Carbon\Carbon::now(),
    //             ]
    //         );
    //         $json['type'] = 'success';
    //         return $json;
    //     }
    // }

    /**
     * Get Search resoluts.
     *
     * @param string $keyword              keyword
     * @param string $search_categories    search_categories
     * @param string $search_locations     search_locations
     * @param string $search_languages     search_languages
     * @param string $search_delivery_time search_deliver
     * @param string $search_response_time search_response_time
     *
     * @return relation
     */
    public static function getSearchResult(
        $keyword,
        $search_categories,
        $search_locations,
        $search_languages,
        $search_delivery_time,
        $search_response_time,
        $search_skills
    ) {
        $json = array();
        $services = Cource::select('*')->where('status', 'published')->orderBy('id', 'DESC');
        $service_id = array();
        $filters = array();
        $filters['type'] = 'instructors';
        if (!empty($keyword)) {
            $filters['s'] = $keyword;
            $services->where('title', 'like', '%' . $keyword . '%')->where('status', 'published')->get();
        };
        if (!empty($search_categories)) {
            $filters['category'] = $search_categories;
            foreach ($search_categories as $key => $search_category) {
                $categor_obj = Category::where('slug', $search_category)->first();
                $category = Category::find($categor_obj->id);

                if (!empty($category->courses)) {
                    $category_services = $category->courses->pluck('id')->toArray();
                    foreach ($category_services as $id) {
                        $service_id[] = $id;
                    }
                }
            }
            $services->where('status', 'published')->whereIn('id', $service_id);
        }
        if (!empty($search_skills)) {
            $filters['skills'] = $search_skills;
            foreach ($search_skills as $key => $search_skill) {
                $skill_obj = Skill::where('slug', $search_skill)->first();
                $skill = Skill::find($skill_obj->id);
                //  dd($skill->courses);
                if (!empty($skill->courses)) {
                    $skill_services = $skill->courses->pluck('id')->toArray();
                    foreach ($skill_services as $id) {
                        $service_id[] = $id;
                    }
                }
            }
            $services->where('status', 'published')->whereIn('id', $service_id);
        }
        if (!empty($search_locations)) {
            $filters['locations'] = $search_locations;
            $locations = Location::select('id')->whereIn('slug', $search_locations)->get()->pluck('id')->toArray();
            $services->where('status', 'published')->whereIn('location_id', $locations);
        }
        if (!empty($search_languages)) {
            $filters['languages'] = $search_languages;
            // $languages = Language::whereIn('slug', $search_languages)->get();

            foreach ($search_languages as $key => $language) {
                $languages = Language::where('slug', $language)->first();
                $lang = Language::find($languages->id);
                if (!empty($lang->courses)) {
                    $lang_courses = $lang->courses->pluck('id')->toArray();
                    foreach ($lang_courses as $id) {
                        $service_id[] = $id;
                    }
                }
            }
            $services->where('status', 'published')->whereIn('id', $service_id);
        }
        if (!empty($search_delivery_time)) {
            $filters['delivery_time'] = $search_delivery_time;
            $delivery_time = DeliveryTime::select('id')->whereIn('slug', $search_delivery_time)->get()->pluck('id')->toArray();
            $services->where('status', 'published')->whereIn('delivery_time_id', $delivery_time);
        }
        if (!empty($search_response_time)) {
            $filters['response_time'] = $search_response_time;
            $response_time = ResponseTime::select('id')->whereIn('slug', $search_response_time)->get()->pluck('id')->toArray();
            $services->where('status', 'published')->whereIn('response_time_id', $response_time);
        }
        $services = $services->orderByRaw("is_featured DESC, updated_at DESC")->paginate(20)->setPath('');
        foreach ($filters as $key => $filter) {
            $pagination = $services->appends(
                array(
                    $key => $filter,
                )
            );
        }
        $json['services'] = $services;
        return $json;
    }
}
