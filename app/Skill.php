<?php

/**
 * Class Skill
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Skill
 *
 */
class Skill extends Model
{
    /**
     * Fillables for the database
     *
     * @access protected
     * @var    array $fillable
     */
    protected $fillable = array(
        'title', 'slug', 'description',
    );

    /**
     * Protected Date
     *
     * @access protected
     * @var    array $dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The freelancer that belong to the skill.
     *
     * @return relation
     */
    public function freelancers()
    {
        return $this->belongsToMany('App\User');
    }
    public function courses()
    {
        return $this->belongsToMany('App\Cource');
    }
    public function blogs()
    {
        return $this->belongsToMany('App\Blog');
    }
    public function services()
    {
        return $this->belongsToMany('App\Service');
    }
    /**
     * The job that belong to the skill.
     *
     * @return relation
     */
    public function jobs()
    {
        return $this->belongsToMany('App\Job');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
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

            if (!Skill::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Skill::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * For saving skills in Database
     *
     * @param mixed $request get req attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSkills($request)
    {
        if (!empty($request)) {

            $this->title = filter_var($request['skill_title'], FILTER_SANITIZE_STRING);
            $this->title = filter_var($request['skill_heading'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['skill_title'], FILTER_SANITIZE_STRING);
            $this->category_id = $request['category_id'];
            $this->logo = filter_var($request['logo'], FILTER_SANITIZE_STRING);
            $this->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $this->description = $request['skill_desc'];
            $skill =  $this->save();
            $this->categories()->sync($request['categories']);
        }
    }

    /**
     * For updating skills
     *
     * @param mixed $request get req attributes
     * @param int   $id      get skill id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSkills($request, $id)
    {
        if (!empty($request)) {
            $skills = self::find($id);
            if ($skills->slug != $request['skill_slug']) {
                $skills->slug = $request['skill_slug'];
            }
            $skills->title = filter_var($request['skill_title'], FILTER_SANITIZE_STRING);
            $skills->heading = filter_var($request['skill_heading'], FILTER_SANITIZE_STRING);
            $skills->logo = filter_var($request['logo'], FILTER_SANITIZE_STRING);
            $skills->category_id = $request['category_id'];
            $skills->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $skills->description = $request['skill_desc'];
            $skills->save();
            $skills->categories()->sync($request['categories']);
        }
    }

    /**
     * For updating skills
     *
     * @param int $user_id get user ID
     *
     * @return \Illuminate\Http\Response
     */
    public static function getFreelancerSkill($user_id)
    {
        return DB::table('skill_user')->select('skill_id')
            ->where('user_id', $user_id)
            ->get()->pluck('skill_id')->toArray();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_skill');
    }


    /**
     * For updating skills
     *
     * @param int $job_id JobId
     *
     * @return \Illuminate\Http\Response
     */
    public static function getJobSkill($job_id)
    {
        return DB::table('job_skill')->select('skill_id')
            ->where('job_id', $job_id)
            ->get()->pluck('skill_id')->toArray();
    }
    public static function getAgencySkill($agency_id)
    {
        return DB::table('agency_user_skill')->select('skill_id')
            ->where('agency_user_id', $agency_id)
            ->get()->pluck('skill_id')->toArray();
    }
    public static function getBlogSkill($blog_id)
    {
        return DB::table('blog_skill')->select('skill_id')
            ->where('blog_id', $blog_id)
            ->get()->pluck('skill_id')->toArray();
    }
    public static function getCourseSkill($course_id)
    {
        return DB::table('cource_skill')->select('skill_id')
            ->where('cource_id', $course_id)
            ->get()->pluck('skill_id')->toArray();
    }
    public static function getServiceSkill($service_id)
    {
        return DB::table('service_skill')->select('skill_id')
            ->where('service_id', $service_id)
            ->get()->pluck('skill_id')->toArray();
    }
    public static function getJob($skill_id)
    {
        return DB::table('job_skill')->select('job_id')
            ->where('skill_id', $skill_id)
            ->get();
    }
}
