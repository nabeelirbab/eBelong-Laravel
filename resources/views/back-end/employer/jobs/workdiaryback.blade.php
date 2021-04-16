@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    @php
        $count = 0;
        $reviews = \App\Review::where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
        $project_type  = Helper::getProjectTypeList($job->project_type);
    @endphp
    <section class="wt-haslayout wt-dbsectionspace" id="jobs">
        <div class="preloader-section" v-if="loading" v-cloak>
            <div class="preloader-holder">
                <div class="loader"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @if (Session::has('success'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('success') }}}'" v-cloak></flash_messages>
                    </div>
                    @php session()->forget('success'); @endphp
                @elseif (Session::has('error'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>Work Diary</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-freelancerholder wt-tabsinfo">
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                    @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                        <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                    @endif
                                    <div class="wt-userlistingcontent">
                                        <div class="wt-contenthead">
                                            @if (!empty($employer_name) || !empty($job->title) )
                                                <div class="wt-title">
                                                    @if (!empty($employer_name))
                                                        <a href="{{{ url('profile/'.$job->employer->slug) }}}">@if ($verified_user === 1)<i class="fa fa-check-circle"></i>@endif&nbsp;{{{ $employer_name }}}</a>
                                                    @endif
                                                    @if (!empty($job->title))
                                                        <h2>{{{ $job->title }}}</h2>
                                                    @endif
                                                </div>
                                            @endif
                                            @if (!empty($job->price) ||
                                                !empty($job->location->title))
                                                <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                    @if (!empty($job->price))
                                                        <li><span class="wt-dashboraddoller"><i>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}</i> {{{ $job->price }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->location->title))
                                                        <li><span><img src="{{{asset(App\Helper::getLocationFlag($job->location->flag))}}}" alt="{{ trans('lang.img') }}"> {{{ $job->location->title }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->project_type))
                                                        <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> {{ trans('lang.type') }} {{{ $project_type }}}</a></li>
                                                    @endif
                                                    @if (!empty($job->duration))
                                                        <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ $duration }}}</span></li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="wt-rightarea">
                                            
                                                     @php
                                                        session()->put(['total_hours' => e($total_hours)]);
                                                                                                               
                                                        @endphp

                                            @if ($job->status === 'hired')
                                                <div class="wt-hireduserstatus">
                                                    <h4>{{ trans('lang.hired') }}</h4>
                                                    <span>{{{ $freelancer_name }}}</span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            @elseif ($job->status === 'completed')
                                                <div class="wt-hireduserstatus">
                                                    <h4>{{ trans('lang.completed') }}</h4>
                                                    <span>{{{ $freelancer_name }}}</span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="wt-hireduserstatus">
                                                    @if (Auth::user()->getRoleNames()[0] == "admin")
                                                        <h4>{{ trans('lang.job_cancelled') }}</h4>
                                                    @else
                                                        <h5>{{ trans('lang.no_freelancers') }}</h5>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                            <div class="wt-tabscontenttitle">
                                <h2>
                                    @php 
                                $currentdate = date("m/d/Y");
                                $date = $currentdate;
                                $ts = strtotime($date);
                                $month = date('F');
                                $dow = date('w', $ts);
                                $offset = $dow - 1;
                                if ($offset < 0) {
                                    $offset = 6;
                                }
                                $ts = $ts - $offset*86400;

                                 echo "Timesheet For". " " . $month .  " ";

                                for ($i = 0 ; $i<7; $i++, $ts += 86400){
                                       if ($i == '0' ) { 
                                     print date("j", $ts);
                                     echo " - " ;
                                 } elseif ($i == '6'){
                                    print date("j", $ts);
                                 }
                                }  

                                echo " (This Week)" ;   

                               @endphp 

                                </h2>
                            </div>
                            <div class="wt-jobdetailscontent">
                               
                                    <div class="wt-userlistinghold wt-featured wt-proposalitem">

                                        <table>
                                              <tr>
                                                
                                                @php 

                                                $bill_hours = App\WorkDiary::where('status', 'pending')->get()->all();
                                                $hours_date = Carbon\Carbon::parse($bill_hours[0]->date)->format('d/m');
                                                $currentdate = date('m/d/Y');
                                                $date = $currentdate;
                                                $ts = strtotime($date);
                                             
                                                $dow = date('w', $ts);
                                                $offset = $dow - 1;
                                                if ($offset < 0) {
                                                    $offset = 6;
                                                }
                                             
                                                $ts = $ts - $offset*86400;
                                                for ($i = 0; $i < 7; $i++, $ts += 86400){
                                                   
                                                    echo  "<th>";
                                                    $date = date("l - d/m", $ts);
                                                    print ($date);
                                                 
                                                }
                                                 

                                                echo "</th>";
                                                echo "<th>";
                                                echo "Hours";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Rate";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Amount";
                                                echo "</th>"; 
                                                echo "</tr>";
                                                
                                                @endphp 

                                             @if ($week_days['Monday'] = 'Monday')
                                                <td>{{{$monday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Tuesday'] = 'Tuesday')
                                                <td>{{{$tuesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Wednesday'] = 'Wednesday')
                                                <td>{{{$wednesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Thursday'] = 'Thursday')
                                                <td>{{{$thursday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Friday'] = 'Friday')
                                                <td>{{{$friday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif                                                
                                                @if ($week_days['Satruday'] = 'Saturday')
                                                <td>{{{$saturday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                @if ($week_days['Sunday'] = 'Sunday')
                                                <td>{{{$sunday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                <td>{{{ $total_hours }}}<td>
                                                {{{ $job->price }}}.00 / hr
                                                <td>${{{$total_hours * $job->price }}}</td>
                                               </tr>

                                              </tr>
                                          </table>
                                        <div class="wt-rightarea">
                                        <div class="wt-btnarea">
                                                     <a href="{{{ url ('hourly/payment-process/' .  $proposal_id->id) }}}" class="wt-btn">Pay Now</a>
                                                    </div>
                                                </div>
			                            </div>
			                        </div>
			                      </div>


			                       <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                                            <div class="wt-tabscontenttitle">
                                                <!--  <h2>Timesheet for Jun 1 - 7 (this week)</h2> -->
                                                <h2>  Billing History </h2>

                                              </div >

                                             

                                        	@php 
                                        	
                                        	$week_days = array ('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        
									        $previous_week = App\WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->get()->all();

									       									        
									       $previous_monday = App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Monday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');
									      

									        $previous_tuesday =  App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Tuesday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');
									        $previous_wednesday = App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Wednesday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');
									        $previous_thursday = App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Thursday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');
									        $previous_friday =  App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Friday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');

									        $previous_saturday = App\WorkDiary::where('project_id', $project_id)->where('WeekDay', 
									        $week_days['Saturday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');

									        
									        $previous_sunday = App\WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Sunday'])->whereBetween('date', [Carbon\Carbon::now()->startOfWeek()->subWeek(), Carbon\Carbon::now()->endOfWeek()->subWeek()])->sum('hours');
									        $total_hours = $previous_monday + $previous_tuesday + $previous_wednesday + $previous_thursday + $previous_friday +  $previous_saturday + $previous_sunday;


                                        	@endphp

                                          @if($previous_bill->status == 'submitted')

                                           <div class="wt-userlistinghold wt-featured wt-proposalitem">
                                            <table>

                                            	 <div class="" >
                                              	<h2 style="font-weight:400; font-size:16px; line-height: 20px; margin-bottom:5px">
                                                @php 

                                                 $now = Carbon\Carbon::now(); 
                                                 $previous_week_date =  $now->endofWeek()->subWeek()->format('m/d/Y');

					                                $currentdate = $previous_week_date;
					                                $date = $currentdate;
					                                $ts = strtotime($date);
					                                $month = date('F');
					                                $dow = date('w', $ts);
					                                $offset = $dow - 1;
					                                if ($offset < 0) {
					                                    $offset = 6;
					                                }
					                                $ts = $ts - $offset*86400;

					                                 echo "Timesheet For". " " . $month .  " ";

					                                for ($i = 0 ; $i<7; $i++, $ts += 86400){
					                                       if ($i == '0' ) { 
					                                     print date("j", $ts);
					                                     echo " - " ;
					                                 } elseif ($i == '6'){
					                                    print date("j", $ts);
					                                 }
					                                }  					                               

					                               @endphp 
                                       			</h2>
                                        	</div>

                                              <tr>

                                                @php
                                                $now = Carbon\Carbon::now(); 
                                                $previous_week_date =  $now->endofWeek()->subWeek()->format('m/d/Y');
                                                

                                               /* $currentdate = date('m/d/Y'); */
                                                $currentdate = $previous_week_date;
                                                $date = $currentdate;
                                                $ts = strtotime($date);
                                                $dow = date('w', $ts);
                                                $offset = $dow - 1;
                                                if ($offset < 0) {
                                                    $offset = 6;
                                                }
                                             
                                                $ts = $ts - $offset*86400;
                                                for ($i = 0; $i < 7; $i++, $ts += 86400){
                                                   
                                                    echo  "<th>";
                                                    $date = date("l - m/d", $ts);
                                                    print ($date);
                                                                                                 
                                                }
                                                 
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Hours";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Rate";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Amount";
                                                echo "</th>"; 
                                                echo "</tr>";
                                               @endphp 


                                                
                                                @if ($week_days['Monday'] = 'Monday')
                                                <td>{{{$previous_monday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Tuesday'] = 'Tuesday')
                                                <td>{{{$previous_tuesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Wednesday'] = 'Wednesday')
                                                <td>{{{$previous_wednesday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Thursday'] = 'Thursday')
                                                <td>{{{$previous_thursday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif 
                                                @if ($week_days['Friday'] = 'Friday')
                                                <td>{{{$previous_friday}}} </td>
                                                @else
                                                <td> - </td>
                                                @endif                                                
                                                @if ($week_days['Satruday'] = 'Saturday')
                                                <td>{{{$previous_saturday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                @if ($week_days['Sunday'] = 'Sunday')
                                                <td>{{{$previous_sunday}}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                <td>{{{ $total_hours }}}<td>
                                                {{{ $job->price }}}.00 / hr
                                                <td>${{{$total_hours * $job->price }}}</td>
                                               </tr>

                                          </table>
                                         <div class="wt-rightarea">
                                          <div class="wt-btnarea">
                                                     <a href="{{{ url ('hourly/payment-process/' .  $proposal_id->id) }}}" class="wt-btn">Pay Now</a>
                                                       </div>
                                                     <div>
                                                   </div>
                                              </div>
                                          @endif

                                          @php  $now = Carbon\Carbon::now();
                                                                                                                               
                                                                                     
                                            echo $current_week;
                                            @endphp
					                   </div>
					                </div>
					            </div> 



                </div>
            </div>

     <!--  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            </div>
        </div>
        <b-modal ref="myModalRef-{{ $accepted_proposal->id }}" hide-footer title="Cover Letter" v-cloak>
            <div class="d-block text-center">
                {{{$accepted_proposal->content}}}
            </div>
        </b-modal>
        <b-modal ref="myModalRef" hide-footer title="Project Status">
            <div class="d-block text-center">
                <form class="wt-formtheme wt-formfeedback" id="submit-review-form">
                    <fieldset>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="{{ trans('lang.add_your_feedback') }}" name="feedback"></textarea>
                        </div>
                        @if(!empty($review_options))
                            @foreach ($review_options as $key => $option)
                                <div class="form-group wt-ratingholder">
                                    <div class="wt-ratepoints">
                                        <vue-stars
                                            :name="'rating[{{$key}}][rate]'"
                                            :active-color="'#fecb02'"
                                            :inactive-color="'#999999'"
                                            :shadow-color="'#ffff00'"
                                            :hover-color="'#dddd00'"
                                            :max="5"
                                            :value="0"
                                            :readonly="false"
                                            :char="'★'"
                                            id="rating-{{$key}}"
                                        />
                                        <div class="counter wt-pointscounter"></div>
                                    </div>
                                    <input type="hidden" name="rating[{{$key}}][reason]" value="{{{$option->id}}}">
                                    <span class="wt-ratingdescription">{{{$option->title}}}</span>
                                </div>
                            @endforeach
                        @endif
                        <input type="hidden" name="receiver_id" value="{{{$accepted_proposal->freelancer_id}}}">
                        <input type="hidden" name="proposal_id" value="{{{$accepted_proposal->id}}}">
                        <div class="form-group wt-btnarea">
                            <a class="wt-btn" href="javascript:void(0);" v-on:click='submitFeedback({{$accepted_proposal->freelancer_id}}, {{$job->id}})'>{{ trans('lang.btn_send_feedback') }}</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </b-modal> -->
    </section>
    @endsection